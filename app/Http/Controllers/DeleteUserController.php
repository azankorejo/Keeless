<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function destroy(Request $request, StatefulGuard $guard): Response
    {
        $user = $request->user()->fresh();
        User::query()->where('id', $user->id)->update(['inactive' => true]);

        $guard->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Inertia::location(url('/'));
    }
}
