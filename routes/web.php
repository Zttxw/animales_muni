<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\EspecieController;
use App\Http\Controllers\Admin\CampanaController as AdminCampana;

use App\Http\Controllers\Ciudadano\DashboardController as CiudadanoDashboard;
use App\Http\Controllers\Ciudadano\AnimalController;
use App\Http\Controllers\Ciudadano\VacunacionController;


/*
|--------------------------------------------------------------------------
| RUTA RAÍZ
|--------------------------------------------------------------------------
| Decide a dónde enviar al usuario según su estado de autenticación
| y su rol.
*/

Route::get('/', function () {

    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (Auth::user()->rol === 'ADMIN') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('ciudadano.dashboard');

});


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);

});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| PANEL ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'estado', 'role:ADMIN'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminDashboard::class, 'index'])
            ->name('dashboard');

        // Usuarios
        Route::resource('usuarios', UsuarioController::class)
            ->except('show');

        // Especies
        Route::get('especies', [EspecieController::class, 'index'])
            ->name('especies.index');

        Route::post('especies', [EspecieController::class, 'store'])
            ->name('especies.store');

        Route::put('especies/{especie}', [EspecieController::class, 'update'])
            ->name('especies.update');

        // Razas
        Route::get('especies/{especie}/razas', [EspecieController::class, 'razas'])
            ->name('especies.razas');

        Route::post('especies/{especie}/razas', [EspecieController::class, 'storeRaza'])
            ->name('especies.razas.store');

        Route::put('razas/{raza}', [EspecieController::class, 'updateRaza'])
            ->name('razas.update');

        // Campañas
        Route::resource('campanas', AdminCampana::class);

});


/*
|--------------------------------------------------------------------------
| PANEL CIUDADANO
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'estado'])
    ->prefix('ciudadano')
    ->name('ciudadano.')
    ->group(function () {

        Route::get('/', [CiudadanoDashboard::class, 'index'])
            ->name('dashboard');

        // Animales
        Route::resource('animales', AnimalController::class);

        // Vacunaciones
        Route::get('animales/{animal}/vacunaciones',
            [VacunacionController::class, 'index'])
            ->name('animales.vacunaciones.index');

        Route::get('animales/{animal}/vacunaciones/crear',
            [VacunacionController::class, 'create'])
            ->name('animales.vacunaciones.create');

        Route::post('animales/{animal}/vacunaciones',
            [VacunacionController::class, 'store'])
            ->name('animales.vacunaciones.store');

});


/*
|--------------------------------------------------------------------------
| API INTERNA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/api/especies/{especie}/razas',
        [AnimalController::class, 'razasPorEspecie'])
        ->name('api.razas');

});