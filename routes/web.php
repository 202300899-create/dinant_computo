<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLADORES
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ComputadoraController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ConfiguracionController;


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'mostrarLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.procesar');


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (REQUIEREN LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['admin.auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | CONFIGURACIÓN
    |--------------------------------------------------------------------------
    */

 Route::get('/configuracion', [ConfiguracionController::class, 'index'])
    ->name('configuracion.index');

Route::put('/configuracion/perfil', [ConfiguracionController::class, 'actualizarPerfil'])
    ->name('configuracion.perfil');

Route::put('/configuracion/password', [ConfiguracionController::class, 'actualizarPassword'])
    ->name('configuracion.password');

Route::post('/configuracion/usuarios', [ConfiguracionController::class, 'guardarNuevoUsuario'])
    ->name('configuracion.usuarios.store');


    /*
    |--------------------------------------------------------------------------
    | INVENTARIO - COMPUTADORAS
    |--------------------------------------------------------------------------
    */

    Route::prefix('computadoras')->controller(ComputadoraController::class)->group(function () {

        Route::get('/', 'index')->name('computadoras.index');

        Route::get('/create', 'create')->name('computadoras.create');

        Route::post('/', 'store')->name('computadoras.store');

        Route::get('/{computadora}', 'show')->name('computadoras.show');

        Route::get('/{computadora}/edit', 'edit')->name('computadoras.edit');

        Route::put('/{computadora}', 'update')->name('computadoras.update');

        Route::delete('/{computadora}', 'destroy')->name('computadoras.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | MANTENIMIENTOS
    |--------------------------------------------------------------------------
    */

    Route::prefix('mantenimientos')->controller(MantenimientoController::class)->group(function () {

        Route::get('/', 'index')->name('mantenimientos.index');

        Route::get('/create', 'create')->name('mantenimientos.create');

        Route::post('/', 'store')->name('mantenimientos.store');

        Route::get('/{mantenimiento}', 'show')->name('mantenimientos.show');

        Route::get('/{mantenimiento}/edit', 'edit')->name('mantenimientos.edit');

        Route::put('/{mantenimiento}', 'update')->name('mantenimientos.update');

        Route::delete('/{mantenimiento}', 'destroy')->name('mantenimientos.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | CALENDARIO
    |--------------------------------------------------------------------------
    */

    Route::get('/calendario', [CalendarioController::class, 'index'])
        ->name('calendario.index');


    /*
    |--------------------------------------------------------------------------
    | USUARIOS
    |--------------------------------------------------------------------------
    */

    Route::prefix('usuarios')->controller(UsuarioController::class)->group(function () {

        Route::get('/', 'index')->name('usuarios.index');

        Route::get('/create', 'create')->name('usuarios.create');

        Route::post('/', 'store')->name('usuarios.store');

        Route::get('/{usuario}', 'show')->name('usuarios.show');

        Route::get('/{usuario}/edit', 'edit')->name('usuarios.edit');

        Route::put('/{usuario}', 'update')->name('usuarios.update');

        Route::delete('/{usuario}', 'destroy')->name('usuarios.destroy');

        Route::post('/{usuario}/asignar-equipo', 'asignarEquipo')
            ->name('usuarios.asignarEquipo');

        Route::put('/{usuario}/quitar-equipo/{computadora}', 'quitarEquipo')
            ->name('usuarios.quitarEquipo');

    });


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});