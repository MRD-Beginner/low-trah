<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SilsilahController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Routes for Keluarga Management
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'route'])->name('dashboard');
    Route::get('user/data/keluarga', [UserController::class, 'keluarga'])->name('user.keluarga');
    Route::post('user/data/keluarga/add', [KeluargaController::class, 'storeUser'])->name('user.keluarga.store');
    Route::put('user/data/keluarga/update/{id}', [KeluargaController::class, 'updateUser'])->name('user.keluarga.update');
    Route::delete('user/data/keluarga/delete/{id}', [KeluargaController::class, 'deleteUser'])->name('user.keluarga.delete');
});

// Admin Routes for Keluarga Management
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/data/keluarga', [AdminController::class, 'keluarga'])->name('admin.keluarga');
    Route::get('admin/data/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('admin/data/keluarga/add', [KeluargaController::class, 'store'])->name('keluarga.store');
    Route::put('admin/data/keluarga/update/{id}', [KeluargaController::class, 'update'])->name('keluarga.update');
    Route::delete('admin/data/keluarga/delete/{id}', [KeluargaController::class, 'delete'])->name('keluarga.delete');
});

Route::post('/keluarga/{id}/verify-password', [KeluargaController::class, 'verifyPassword'])
    ->name('keluarga.verify.password');

Route::get('detail/public/data/keluarga/data/{id}', [KeluargaController::class, 'detail_public'])->name('keluarga.detail.public');

Route::get('/detail/public/data/keluarga/pohon/{id}', [KeluargaController::class, 'pohon'])->name('keluarga.detail.pohon');

Route::get('detail/public/data/keluarga/hubungan/{id}', [KeluargaController::class, 'hubungan'])->name('keluarga.detail.hubungan');

Route::post('keluarga/detail/public/add', [SilsilahController::class, 'create_anggota_keluarga'])->name('anggota.keluarga.store');

Route::get('keluarga/detail/public/edit/{id}', [SilsilahController::class, 'edit_anggota_keluarga'])->name('anggota.keluarga.edit');

Route::put('keluarga/detail/public/update/{id}', [SilsilahController::class, 'update_anggota_keluarga'])->name('anggota.keluarga.update');

Route::delete('keluarga/detail/public/delete/{id}', [SilsilahController::class, 'delete_anggota_keluarga'])->name('anggota.keluarga.delete');

Route::post('keluarga/detail/public/add/pasangan', [SilsilahController::class, 'create_pasangan_anggota_keluarga'])->name('pasangan.anggota.keluarga.store');

Route::get('keluarga/detail/public/edit/pasangan/{id}', [SilsilahController::class, 'edit_pasangan_anggota_keluarga'])->name('pasangan.anggota.keluarga.edit');

Route::put('keluarga/detail/public/update/pasangan/{id}', [SilsilahController::class, 'update_pasangan_anggota_keluarga'])->name('pasangan.anggota.keluarga.update');

Route::delete('keluarga/detail/public/delete/pasangan/{id}', [SilsilahController::class, 'delete_pasangan_anggota_keluarga'])->name('pasangan.anggota.keluarga.delete');

Route::get('keluarga/detail/private/{id}', [KeluargaController::class, 'detail_private'])->name('keluarga.detail.private');

Route::get('keluarga/detail/public/data/keluarga/pohon_output/{id}', [KeluargaController::class, 'pohon_output'])->name('keluarga.detail.pohon_output');

Route::fallback(function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return auth()->user()->hasRole('admin')
        ? redirect()->route('admin.keluarga')
        : redirect()->route('user.keluarga');
});

require __DIR__ . '/auth.php';
