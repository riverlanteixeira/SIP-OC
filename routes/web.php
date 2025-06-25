<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizationController; // Importa o nosso controller
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // AQUI ESTÁ A NOSSA ROTA, NO LUGAR CERTO E COM TUDO QUE PRECISA
    Route::resource('organizations', OrganizationController::class);
});
Route::middleware('auth')->group(function () {
    // ... rotas do profile
    Route::resource('organizations', OrganizationController::class);
    Route::resource('people', PersonController::class); 
});

Route::middleware('auth')->group(function () {
    // ... rotas existentes ...
    Route::resource('organizations', OrganizationController::class);
    Route::resource('people', PersonController::class);
    Route::resource('investigations', InvestigationController::class); 
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
});

Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);

require __DIR__.'/auth.php';