<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========================
// Halaman Awal
// ========================
Route::get('/', function () {
    return redirect()->route('login');
});

// ========================
// Dashboard (Admin & Staff)
// ========================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('staff.dashboard');
    })->name('dashboard');

    // Dashboard Admin
    Route::get('/admin/dashboard', [UserController::class, 'staffDashboard'])->name('admin.dashboard');

    // Dashboard Staff
    Route::get('/staff/dashboard', [UserController::class, 'staffDashboard'])->name('staff.dashboard');
});

// ========================
// Profile (Umum)
// ========================


// ========================
// Admin Routes
// ========================
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // Manajemen User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Halaman Admin
    Route::get('/stok', [AdminController::class, 'stok'])->name('admin.stok');
    Route::get('/profil', [UserController::class, 'profil'])->name('profil');
    
    // Register Staff
    Route::get('/admin/register', [RegisteredUserController::class, 'create'])->name('admin.register');
    Route::post('/admin/register', [RegisteredUserController::class, 'store'])->name('admin.register');

    Route::put('/admin/users/{id_user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id_user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // CRUD Produk
    Route::post('/produk', [AdminController::class, 'storeProduk'])->name('produk.store');
    Route::put('/produk/{id_prod}', [AdminController::class, 'updateProduk'])->name('produk.update');
    Route::delete('/produk/{id_prod}', [AdminController::class, 'destroyProduk'])->name('produk.destroy');

    // CRUD Perlengkapan
    Route::post('/perlengkapan', [AdminController::class, 'storePerlengkapan'])->name('perlengkapan.store');
    Route::put('/perlengkapan/{id_per}', [AdminController::class, 'updatePerlengkapan'])->name('perlengkapan.update');
    Route::delete('/perlengkapan/{id_per}', [AdminController::class, 'destroyPerlengkapan'])->name('perlengkapan.destroy');
    
    Route::get('/laporan/download', [FileController::class, 'downloadPdf'])->name('laporan.download');

    // Laporan
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/filter', [AdminController::class, 'filterLaporan'])->name('admin.laporan.filter');
});

// ========================
// Staff Routes
// ========================
Route::middleware(['auth', 'role:staff'])->group(function () {
    // Halaman stok
    Route::get('/staff/stok', [UserController::class, 'stok'])->name('stok');

    //stok
    Route::put('/staff/perlengkapan/{id_per}', [UserController::class, 'updatePerlengkapan'])->name('staff.perlengkapan.update');
    Route::put('/staff/produk/{id_prod}', [UserController::class, 'updateProduk'])->name('staff.produk.update');
});


// ========================
// Auth Routes (Breeze)
// ========================
require __DIR__ . '/auth.php';
