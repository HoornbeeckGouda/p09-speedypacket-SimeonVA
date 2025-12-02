<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    UserController,
    TwoFactorCodeController,
    Auth\AuthenticatedSessionController,
    PakketController
};
use App\Http\Controllers\Auth\{
    PasswordResetLinkController,
    NewPasswordController
};

// GET route - toon login pagina
Route::get('/', fn() => view('auth.login'))
    ->middleware('guest')
    ->name('login');

// POST route - verwerk login
Route::post('/', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

// Two-factor verificatie routes (ZONDER two.factor middleware!)
Route::middleware('auth')->group(function () {
    Route::get('/verify', [TwoFactorCodeController::class, 'verify'])->name('verify');
    Route::post('/verify', [TwoFactorCodeController::class, 'verifyPost'])->name('verify.post');
    Route::get('/verify/resend', [TwoFactorCodeController::class, 'resend'])->name('verify.resend');
});

// Dashboard (MET two.factor middleware)
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified', 'two.factor'])
    ->name('dashboard');

    Route::get('/dashboard', [PakketController::class, 'index'])->name('dashboard');

    /*
|--------------------------------------------------------------------------
| Pakketten beheer
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Pakketten beheer
|--------------------------------------------------------------------------
*/
Route::prefix('pakketten')->middleware(['auth'])->group(function () {
    Route::get('/', [PakketController::class, 'index'])
        ->name('pakketten.index');

    Route::get('/create', [PakketController::class, 'create'])
        ->name('pakketten.create');

    Route::post('/', [PakketController::class, 'store'])
        ->name('pakketten.store');

    Route::get('/{pakket}', [PakketController::class, 'show'])
        ->name('pakketten.show');

    Route::get('/{pakket}/edit', [PakketController::class, 'edit'])
        ->name('pakketten.edit');

    Route::put('/{pakket}', [PakketController::class, 'update'])
        ->name('pakketten.update');

    Route::delete('/{pakket}', [PakketController::class, 'destroy'])
        ->name('pakketten.destroy');
});


// Profile routes
Route::middleware(['auth', 'two.factor'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Password reset routes
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

require __DIR__ . '/auth.php';