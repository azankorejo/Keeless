<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserOtpValidationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Laravel\Fortify\LoginRateLimiter;

class UserOTPVerificationController extends Controller
{

    /**
     * The guard implementation.
     *
     * @var StatefulGuard
     */
    protected StatefulGuard $guard;

    /**
     * Create a new controller instance.
     *
     * @param StatefulGuard $guard
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

        /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'email' => 'required|string|email',
        ]);
        $user = User::query()->where('email', $request->email)->first();

        if(!$user) {
            return back()->withErrors(['error' => 'No record with this otp exists.']);
        }
        if($user->otp !== $request->otp) {
            return back()->withErrors(['error' => 'The given otp code is not valid.']);
        }
        $emailVerifiedTime = Carbon::parse($user->email_verified_at);
        if ($emailVerifiedTime->diffInHours(now()) > 1) {
            return back()->withErrors(['error' => 'Your otp code has expired. Please try logging in again.']);
        }

        $user->otp = null;
        $user->email_verified_at = now();
        $user->save();
        $this->guard->login($user);

        return redirect('/dashboard');
    }
}
