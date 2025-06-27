<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\TattooController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\IncarcerationController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BankAccountController;

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
    Route::post('/tattoos', [TattooController::class, 'store'])->name('tattoos.store');
    Route::delete('/tattoos/{tattoo}', [TattooController::class, 'destroy'])->name('tattoos.destroy');

    Route::resource('organizations', OrganizationController::class);
    Route::resource('people', PersonController::class);

    // Rotas específicas devem vir antes das rotas de recurso genéricas
    Route::get('/investigations/{investigation}/pdf', [InvestigationController::class, 'downloadPdf'])->name('investigations.pdf');
    Route::resource('investigations', InvestigationController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/incarcerations', [IncarcerationController::class, 'store'])->name('incarcerations.store');
    Route::delete('/incarcerations/{incarceration}', [IncarcerationController::class, 'destroy'])->name('incarcerations.destroy');
    Route::resource('bank-accounts', BankAccountController::class);
});



require __DIR__ . '/auth.php';