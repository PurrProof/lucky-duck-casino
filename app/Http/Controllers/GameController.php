<?php

namespace App\Http\Controllers;

use App\Services\GameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function __construct(private GameService $gameService, private Request $request) {}

    public function playGame()
    {
        $result = $this->gameService->playGame(Auth::user());

        return redirect()->route('dashboard')
            ->with('result', $result);
    }
}
