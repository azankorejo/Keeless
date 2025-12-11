<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UsersIndexontroller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $teamId = Auth::user()->currentTeam->id;
        $hasUsername = Consumer::query()->whereNotNull('username')->exists();
        $users = Consumer::query()->when($request->search, function ($q) use ($request) {
            $q->where('email', 'LIKE', '%'.$request->search.'%')->orWhere('username', 'LIKE', '%'.$request->search);
        })
            ->orderByDesc('id')
            ->where('team_id', $teamId)
            ->paginate(10, ['username', 'email', 'active', 'id', 'created_at']);

        return Inertia::render('Users', [
            'users' => $users,
            'search' => $request->search,
            'has_username' => $hasUsername
        ]);
    }
}
