<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class LinkController extends Controller
{
    public function __construct(private LinkService $linkService) {}

    public function generateLink(): RedirectResponse
    {
        try {
            $this->linkService->createNewLink(Auth::user());
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->withErrors(['error' => $e->getMessage()]);
        }
        return redirect()->route('dashboard')->withFragment("links")->with('success', 'New link generated.');
    }

    public function deactivateLink(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|uuid',
        ]);

        try {
            $this->linkService->deactivateLinkByCode(Auth::user(), $request->code);
            return redirect()->route('dashboard')->withFragment("links")->with('success', 'Link deactivated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
