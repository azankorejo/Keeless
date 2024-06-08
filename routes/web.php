<?php

use App\Http\Controllers\Api\V1\Auth\APIKeyGeneratorController;
use App\Http\Controllers\Api\V1\CustomRegisteredUserController;
use App\Http\Controllers\DeleteUserController;
use App\Http\Controllers\Domain\Auth\LoginIndexController;
use App\Http\Controllers\LoginOtpIndexController;
use App\Http\Middleware\CheckDomainExists;
use App\Http\Middleware\EmailVerifiedMiddleware;
use App\Http\Middleware\RedirectToSubdomain;
use App\Http\Middleware\UsingCustomAuthenticationPagesMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/login/otp', [LoginOtpIndexController::class, '__invoke'])->name('login.otp');
Route::post('/register', [CustomRegisteredUserController::class, 'store'])->name('register');
Route::post('login/otp/verification', [\App\Http\Controllers\UserOTPVerificationController::class, '__invoke'])->name('user.otp-verify');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardIndexController::class, '__invoke'])->name('dashboard');
    Route::get('/setup', [\App\Http\Controllers\SetupIndexController::class, '__invoke'])->name('setup');
    Route::get('/email', [\App\Http\Controllers\EmailIndexController::class, '__invoke'])->name('email');
    Route::get('/users', [\App\Http\Controllers\UsersIndexontroller::class, '__invoke'])->name('users');
    Route::get('/branding', [\App\Http\Controllers\BrandingIndexontroller::class, '__invoke'])->name('branding');
    Route::get('api-keys', [\App\Http\Controllers\Api\V1\Auth\APIKeysIndexController::class, '__invoke'])->name('api-keys');

    Route::post('user/delete', [\App\Http\Controllers\Api\V1\UsersDeleteController::class, '__invoke'])->name('user.delete');
    if (Jetstream::hasAccountDeletionFeatures()) {
        Route::delete('/user', [DeleteUserController::class, 'destroy'])
            ->name('user.destroy');
    }
    Route::post('user/activation', [\App\Http\Controllers\Api\V1\UsersActivationController::class, '__invoke'])->name('user.activation');
    Route::post('jwt-config/store', [\App\Http\Controllers\Api\V1\JWTConfigStoreController::class, '__invoke'])->name('jwt-config.store');
    Route::put('branding/store', [\App\Http\Controllers\Api\V1\BrandingStoreController::class, '__invoke'])->name('branding.store');
    Route::post('email/template/store', [\App\Http\Controllers\Api\V1\TemplateInfoStoreController::class, '__invoke'])->name('template-info.store');
    Route::post('setup/domains/store', [\App\Http\Controllers\Api\V1\DomainStoreController::class, '__invoke'])->name('domains.store');
    Route::post('setup/business/store', [\App\Http\Controllers\Api\V1\BusinessInfoStoreController::class, '__invoke'])->name('business.store');
    Route::post('setup/email/store', [\App\Http\Controllers\Api\V1\EmailInfoStoreController::class, '__invoke'])->name('email-info.store');
    Route::post('setup/redirection/store', [\App\Http\Controllers\Api\V1\RedirectionStoreController::class, '__invoke'])->name('redirection.store');
    Route::post('/api-keys/generate', [APIKeyGeneratorController::class, '__invoke'])->name('api-key.generate');
    Route::delete('/api-keys/delete/{token}', [\App\Http\Controllers\Api\V1\Auth\APIKeyDeleteController::class, '__invoke'])->name('api-key.delete');
});
Route::get('/uploads/{filename}', [\App\Http\Controllers\UploadsIndexController::class, '__invoke'])->name('uploads.show');


Route::middleware(CheckDomainExists::class)->withoutMiddleware(RedirectToSubdomain::class)->group(function() {
    Route::domain('{subdomain}.' . config('app.url'))->group(function () {
        Route::middleware(UsingCustomAuthenticationPagesMiddleware::class)->group(function () {
            Route::get('consumer/register', [\App\Http\Controllers\Domain\Auth\RegisterIndexController::class, '__invoke'])->name('consumer.register');
            Route::get('consumer/login', [LoginIndexController::class, '__invoke'])->name('consumer.login');
            Route::get('consumer/otp', [\App\Http\Controllers\Domain\Auth\OTPValidtionController::class, '__invoke'])->name('consumer.otp');
            Route::get('consumer/email-sent', [\App\Http\Controllers\Domain\Auth\EmailSentIndexController::class, '__invoke'])->name('consumer.otp');
            Route::get('consumer/magic-link-sent', [LoginIndexController::class, '__invoke'])->name('consumer.magic');
        });
        Route::get('consumer/magic/verification/{token}', [\App\Http\Controllers\Domain\Auth\MagicLinkVerificationController::class, '__invoke'])->name('consumer.magic-verify');
    });
});


Route::middleware(CheckDomainExists::class)->withoutMiddleware(RedirectToSubdomain::class)->group(function() {
    Route::domain('{subdomain}.' . config('app.url'))->group(function () {
        Route::middleware(\App\Http\Middleware\ApiAuthenticationMiddleware::class)->prefix('api')->group(function() {
            Route::post('consumer/otp/verification', [\App\Http\Controllers\Domain\Auth\OTPVerificationController::class, '__invoke'])->name('consumer.otp-verify');
            Route::post('login', [\App\Http\Controllers\Domain\Api\V1\Auth\LoginController::class, '__invoke'])->name('consumer.login-post');
            Route::post('register', [\App\Http\Controllers\Domain\Api\V1\Auth\RegisterController::class, '__invoke'])->name('consumer.register-post');
            Route::post('logout', [\App\Http\Controllers\Domain\Api\V1\Auth\LogoutController::class, '__invoke'])->name('consumer.logout');
            Route::post('authenticate/{token}', [\App\Http\Controllers\Domain\Api\V1\Auth\TokenAuthenticator::class, '__invoke'])->name('consumer.token-auth');
        });
    });
});
