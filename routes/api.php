<?php


use App\Http\Middleware\CheckDomainExists;
use App\Http\Middleware\RedirectToSubdomain;
use Illuminate\Support\Facades\Route;

Route::middleware(CheckDomainExists::class)->withoutMiddleware(RedirectToSubdomain::class)->group(function() {
    Route::domain('{subdomain}.' . config('app.url'))->group(function () {
        Route::middleware(\App\Http\Middleware\ApiAuthenticationMiddleware::class)->group(function() {
            Route::post('/v1/consumer/otp/verification', [\App\Http\Controllers\Domain\Auth\OTPVerificationController::class, '__invoke'])->name('consumer.otp-verify-v2');
            Route::post('/v1/login', [\App\Http\Controllers\Domain\Api\V1\Auth\LoginController::class, '__invoke'])->name('consumer.login-post-v2');
            Route::post('/v1/register', [\App\Http\Controllers\Domain\Api\V1\Auth\RegisterController::class, '__invoke'])->name('consumer.register-post-v2');
            Route::post('/v1/logout', [\App\Http\Controllers\Domain\Api\V1\Auth\LogoutController::class, '__invoke'])->name('consumer.logout-v2');
            Route::post('/v1/authenticate/{token}', [\App\Http\Controllers\Domain\Api\V1\Auth\TokenAuthenticator::class, '__invoke'])->name('consumer.token-auth-v2');
        });
});
});
