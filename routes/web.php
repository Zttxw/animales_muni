<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\EspecieController;
use App\Http\Controllers\Admin\CampanaController as AdminCampana;
use App\Http\Controllers\Ciudadano\DashboardController as CiudadanoDashboard;
use App\Http\Controllers\Ciudadano\AnimalController;
use App\Http\Controllers\Ciudadano\VacunacionController;

// ── Públicas ──────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ── Auth ──────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

// ── Admin ─────────────────────────────────────────────────────
Route::middleware(['auth', 'estado', 'role:ADMIN'])
    ->prefix('admin')->name('admin.')->group(function () {

    Route::get('/',          [AdminDashboard::class, 'index'])->name('dashboard');

    // Usuarios
    Route::resource('usuarios', UsuarioController::class)->except('show');

    // Especies y razas
    Route::get('especies',              [EspecieController::class, 'index'])->name('especies.index');
    Route::post('especies',             [EspecieController::class, 'store'])->name('especies.store');
    Route::put('especies/{especie}',    [EspecieController::class, 'update'])->name('especies.update');
    Route::get('especies/{especie}/razas',      [EspecieController::class, 'razas'])->name('especies.razas');
    Route::post('especies/{especie}/razas',     [EspecieController::class, 'storeRaza'])->name('especies.razas.store');
    Route::put('razas/{raza}',                  [EspecieController::class, 'updateRaza'])->name('razas.update');

    // Campañas
    Route::resource('campanas', AdminCampana::class);
});

// ── Ciudadano ─────────────────────────────────────────────────
Route::middleware(['auth', 'estado'])
    ->prefix('ciudadano')->name('ciudadano.')->group(function () {

    Route::get('/',             [CiudadanoDashboard::class, 'index'])->name('dashboard');

    // Animales
    Route::resource('animales', AnimalController::class);

    // Vacunaciones (sub-recurso de animal)
    Route::get('animales/{animal}/vacunaciones',        [VacunacionController::class, 'index'])->name('animales.vacunaciones.index');
    Route::get('animales/{animal}/vacunaciones/crear',   [VacunacionController::class, 'create'])->name('animales.vacunaciones.create');
    Route::post('animales/{animal}/vacunaciones',       [VacunacionController::class, 'store'])->name('animales.vacunaciones.store');
});

// ── API interna ───────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/api/especies/{especie}/razas', [AnimalController::class, 'razasPorEspecie'])->name('api.razas');
});
