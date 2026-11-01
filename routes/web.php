<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CoordinatorController;
Route::middleware('guest')->group(function () {
    Route::get('/', fn () => redirect()->route('login'));
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});
Route::middleware(['auth','role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.user'))->name('dashboard');
    Route::get('/reports/create', [ReportController::class,'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class,'store'])->name('reports.store');
    Route::get('/reports', [ReportController::class,'index'])->name('reports.index');
    Route::get('/reports/{report}/edit', [ReportController::class,'edit'])->name('reports.edit');
    Route::put('/reports/{report}', [ReportController::class,'update'])->name('reports.update');
    Route::get('/reports/{report}/evidence', [ReportController::class,'downloadEvidence'])->name('reports.evidence');
});
Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.admin'))->name('dashboard');
    Route::get('/reports', [ReportController::class,'adminIndex'])->name('reports.index');
    Route::get('/reports/{report}', [ReportController::class,'show'])->name('reports.show');
    Route::get('/reports/{report}/evidence', [ReportController::class,'downloadEvidence'])->name('reports.evidence');
    Route::post('/reports/{report}/review', [ReportController::class,'markReviewed'])->name('reports.review');
});
Route::middleware(['auth','role:coordinator'])->prefix('coordinator')->name('coordinator.')->group(function () {
    Route::get('/dashboard', [CoordinatorController::class,'dashboard'])->name('dashboard');
    Route::get('/users', [CoordinatorController::class,'users'])->name('users');
    Route::patch('/users/{user}/role', [CoordinatorController::class,'updateRole'])->name('users.role');
    Route::get('/distributions', [CoordinatorController::class,'distributions'])->name('distributions');
    Route::post('/schools', [CoordinatorController::class,'storeSchool'])->name('schools.store');
    Route::post('/sppgs', [CoordinatorController::class,'storeSppg'])->name('sppgs.store');
    Route::put('/schools/{school}/distribution', [CoordinatorController::class,'syncDistribution'])->name('schools.distribution');
    Route::get('/reports/{report}/evidence', [ReportController::class,'downloadEvidence'])->name('reports.evidence');
});
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth')->name('logout');
