<?php

namespace App\Services;

use App\Models\User;
use App\Models\Link;
use App\Exceptions\UserRegisterException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected LinkService $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function register(array $userData): string
    {
        $userData = $this->normalizeUserData($userData);

        return DB::transaction(function () use ($userData) {
            $user = $this->findExistingUser($userData);

            if ($user) {
                return $this->handleExistingUser($user, $userData);
            }

            return $this->handleNewUser($userData);
        });
    }

    public function loginByLink(Link $link): void
    {
        $user = $link->user;
        $user->update(['logged_at' => now()]);

        Auth::login($user);

        session(['valid_until' => $link->valid_until]);
    }

    public function logout(): void
    {
        Auth::logout();
        session()->flush();
    }

    protected function handleExistingUser(User $user, array $userData): string
    {
        if ($user->phone !== $userData['phone'] || $user->login !== $userData['login']) {
            throw new UserRegisterException('Phone or username is already in use by another user.');
        }

        $activeLink = $this->linkService->getActiveByUser($user) ?? $this->linkService->createNewLink($user);

        $this->loginByLink($activeLink);

        return $activeLink->code;
    }

    protected function handleNewUser(array $userData): string
    {
        $user = $this->registerUser($userData);
        $link = $this->linkService->createNewLink($user);

        $this->loginByLink($link);

        return $link->code;
    }

    protected function findExistingUser(array $userData): ?User
    {
        return User::where('phone', $userData['phone'])
            ->orWhere('login', $userData['login'])
            ->first();
    }

    protected function registerUser(array $userData): User
    {
        return User::create([
            'phone' => $userData['phone'],
            'login' => $userData['login'],
            'registered_at' => now(),
        ]);
    }

    protected function normalizeUserData(array $userData): array
    {
        $userData['phone'] = preg_replace('/\D+/', '', $userData['phone']);
        return $userData;
    }
}
