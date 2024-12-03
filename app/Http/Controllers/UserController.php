<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Services\UserService;
use App\Services\LinkService;
use App\Services\GameService;
use App\Exceptions\UserRegisterException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function showRegForm()
    {
        // pass userslist for just comfortable reg/login testing
        return view('register', ['users' => \App\Models\User::select('login', 'phone')->get()]);
    }

    public function register(UserRegisterRequest $request): RedirectResponse
    {
        try {
            $link = $this->userService->register($request->validated());
            return redirect()
                ->route('user.register')
                ->with('link', $link)
                ->with('success', 'Registration successful!');
        } catch (UserRegisterException $e) {
            return redirect()
                ->route('user.register')
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function login(LinkService $linkService, $uuid)
    {
        $link = $linkService->getActiveByCode($uuid);
        if (!$link) {
            $this->userService->logout();
            return redirect()->route('user.register')->withErrors(['error' => 'This link has expired or is invalid.']);
        }

        $this->userService->loginByLink($link);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        $this->userService->logout();
        return redirect()->route('user.register')->with('success', 'You have been logged out.');
    }

    public function showDashboard(LinkService $linkService, GameService $gameService, Request $request)
    {
        $links = $linkService->userLinks(Auth::user());
        $games = $gameService->getHistory(Auth::user());
        return view('dashboard', compact('links', 'games'));
    }
}
