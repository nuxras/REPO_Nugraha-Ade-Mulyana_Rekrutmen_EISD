<?php

use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\ReportController as WargaReportController;
use App\Http\Controllers\Warga\ProfileController as WargaProfileController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\ReportController as PetugasReportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page — redirect to dashboard if logged in
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'petugas' => redirect()->route('petugas.dashboard'),
            default   => redirect()->route('warga.dashboard'),
        };
    }
    return view('welcome');
});

// Generic dashboard redirect (for Breeze compatibility)
Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin'   => redirect()->route('admin.dashboard'),
        'petugas' => redirect()->route('petugas.dashboard'),
        default   => redirect()->route('warga.dashboard'),
    };
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Warga Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');

    // Reports
    Route::get('/reports', [WargaReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [WargaReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [WargaReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}', [WargaReportController::class, 'show'])->name('reports.show');

    // Profile
    Route::get('/profile', [WargaProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [WargaProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Petugas Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');

    // Reports
    Route::get('/reports/{report}', [PetugasReportController::class, 'show'])->name('reports.show');
    Route::put('/reports/{report}/status', [PetugasReportController::class, 'updateStatus'])->name('reports.update-status');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Categories CRUD
    Route::resource('categories', AdminCategoryController::class);

    // Users CRUD
    Route::resource('users', AdminUserController::class)->except(['show']);

    // Reports (read-only)
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [AdminReportController::class, 'show'])->name('reports.show');
});

require __DIR__.'/auth.php';
