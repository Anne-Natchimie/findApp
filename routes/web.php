<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\public\PublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AnnonceAdminController;

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

Route::get('/public', function () {
    return view('public.accueil');
});

Route::get('/public', [PublicController::class, 'index'])->name('public.accueil');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/favori/add/{id}', [ProfileController::class, 'favoriAdd'])->name('profile.favori.add');
});

//Création et gestion des routes pour l'administration 

Route::middleware('auth','can:admin')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::post('/admin/category', [CategoryController::class, 'store'])->name('admin.category.add');
    Route::post('/admin/category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::get('/admin/category/del/{id}', [CategoryController::class, 'destroy'])->name('admin.category.del');

    Route::get('/admin/annonce', [AnnonceAdminController::class, 'index'])->name('admin.annonce'); 
    Route::get('/admin/annonce/store', [AnnonceAdminController::class, 'create'])->name('admin.annonce.create');
    Route::post('/admin/annonce/store', [AnnonceAdminController::class, 'store'])->name('admin.annonce.store'); 
    Route::get('/admin/annonce/edit/{id}', [AnnonceAdminController::class, 'edit'])->name('admin.annonce.edit'); 
    Route::post('/admin/annonce/edit/{id}', [AnnonceAdminController::class, 'update'])->name('admin.annonce.update'); 
    Route::get('/admin/annonce/delete/{id}', [AnnonceAdminController::class, 'destroy'])->name('admin.annonce.delete'); 

    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user'); 

}); 

require __DIR__.'/auth.php';
