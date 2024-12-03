<?php

namespace App\Services;

use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;


class LinkService
{
    public function createNewLink(User $user): Link
    {
        $validityMins = config('my.link_validity_mins', 7 * 24 * 60);

        $link = $user->links()->create([
            'code' => Str::uuid()->toString(),
            'valid_until' => now()->addMinutes($validityMins),
            'is_deactivated' => false,
        ]);

        return $link;
    }

    public function deactivateLinkByCode(User $user, string $code): void
    {
        $updatedRows = Link::where('code', $code)
            ->where('user_id', $user->id)
            ->where('valid_until', '>=', now())
            ->where('is_deactivated', false)
            ->update(['is_deactivated' => true]);

        if ($updatedRows === 0) {
            throw new \Exception('Link not found or already inactive/deactivated.');
        }
    }

    public function userLinks(User $user): Collection
    {
        return Link::where('user_id', $user->id)
            ->orderBy('valid_until', 'desc')
            ->get();
    }

    public function getActiveByCode(string $uuid): ?Link
    {
        return Link::where('code', $uuid)
            ->where('is_deactivated', false)
            ->where('valid_until', '>=', now())
            ->first();
    }

    public function getActiveByUser(User $user): ?Link
    {
        return $user->links()
            ->where('is_deactivated', false)
            ->where('valid_until', '>=', now())
            ->first();
    }
}
