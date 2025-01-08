<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DireccionGruposPrioritariosController;
use App\Http\Controllers\UserController;

// Redirección inicial
Route::get('/', function () {
    return auth()->check() ? redirect()->route('menu') : redirect()->route('login');
});

// Rutas de autenticación
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
});

// Rutas públicas
Route::controller(FormController::class)->group(function () {
    Route::get('/form', 'showForm');
    Route::post('/form', 'submitForm');
});

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/menu', [MenuController::class, 'showMenu'])->name('menu');
    Route::get('/profile', [ProfileController::class, 'showProfile']);
    Route::post('/profile', [ProfileController::class, 'updateProfile']);
    Route::get('/direccion_grupos_prioritarios/menu', [DireccionGruposPrioritariosController::class, 'menu'])->name('direccion_grupos_prioritarios.menu');
});


Route::get('register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [UserController::class, 'register']);
