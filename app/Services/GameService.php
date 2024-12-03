<?php

namespace App\Services;

use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Collection;


class GameService
{
    public function playGame(User $user): array
    {
        $randomNumber = rand(1, 1000);
        $isWon = $this->isWinningNumber($randomNumber);
        $prize = $isWon ? $this->calculatePrize($randomNumber) : 0;

        $this->storeGameResult($user->id, $randomNumber, $prize, $isWon);

        return [
            'randomNumber' => $randomNumber,
            'isWon' => $isWon,
            'prize' => $prize,
        ];
    }

    public function getHistory(User $user, int $limit = null): Collection
    {
        $limit = $limit ?? config('my.num_games_visible', 3);

        return $user->games()
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    protected function isWinningNumber(int $randomNumber): bool
    {
        return $randomNumber % 2 === 0;
    }

    protected function calculatePrize(int $randomNumber): int
    {
        if ($randomNumber > 900) {
            return (int) round($randomNumber * 0.7);
        } elseif ($randomNumber > 600) {
            return (int) round($randomNumber * 0.5);
        } elseif ($randomNumber > 300) {
            return (int) round($randomNumber * 0.3);
        } else {
            return (int) round($randomNumber * 0.1);
        }
    }

    protected function storeGameResult(int $userId, int $randomNumber, int $prize, bool $isWon): void
    {
        Game::create([
            'user_id' => $userId,
            'random' => $randomNumber,
            'prize' => $prize,
            'is_won' => $isWon,
        ]);
    }
}
