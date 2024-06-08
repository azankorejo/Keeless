<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class APIKeyGeneratorController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws \Exception
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $api = ApiKey::query()->create([
            'team_id' => auth()->user()->currentTeam->id,
            'name' => $request->name,
            'last_used' => now(),
            'key' => 'sk_' . bin2hex(random_bytes(30)), // Generate a random 128-bit key
        ]);
        return back()->with('flash', [
            'token' => $api->key,
        ]);
    }
}
