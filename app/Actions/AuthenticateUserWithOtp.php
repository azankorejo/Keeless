<?php
namespace App\Actions;

use App\Jobs\AppOtpCodeSendJob;
use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\LoginRateLimiter;

class AuthenticateUserWithOtp {
    /**
     * The guard implementation.
     *
     * @var StatefulGuard
     */
    protected $guard;

    /**
     * The login rate limiter instance.
     *
     * @var LoginRateLimiter
     */
    protected $limiter;

    /**
     * Create a new controller instance.
     *
     * @param StatefulGuard $guard
     * @param LoginRateLimiter $limiter
     * @return void
     */
    public function __construct(StatefulGuard $guard, LoginRateLimiter $limiter)
    {
        $this->guard = $guard;
        $this->limiter = $limiter;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function handle(Request $request, callable $next): mixed
    {
        $user = User::query()->where('email', $request->email)->first();
        if($user) {
            AppOtpCodeSendJob::dispatch($user);
            $encoded_email = urlencode($request->email);
            return redirect('/login/otp?email=' .$encoded_email);
        }
        return $this->throwFailedAuthenticationException($request);

//        $this->guard->login($user, $request->boolean('remember'));

    }
    /**
     * Throw a failed authentication validation exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function throwFailedAuthenticationException($request)
    {
        $this->limiter->increment($request);

        throw ValidationException::withMessages([
            Fortify::username() => [trans('auth.failed')],
        ]);
    }
}
