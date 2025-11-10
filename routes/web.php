<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\OwnerController;

// Landing Page Routes (Public)
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/package/{id}', [LandingController::class, 'packageDetail'])->name('landing.package.detail');
Route::get('/booking/{id}', [LandingController::class, 'booking'])->name('landing.booking');
Route::post('/booking', [LandingController::class, 'storeBooking'])->name('landing.booking.store');
Route::get('/booking-success/{id}', [LandingController::class, 'bookingSuccess'])->name('landing.booking.success');
Route::get('/bookings/{id}/download-ticket', [AdminController::class, 'downloadTicketPDF'])->name('landing.booking.download-ticket');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
});

// Logout route for authenticated users
Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/force-logout/{userId}', [App\Http\Controllers\AuthController::class, 'forceLogout'])->name('force.logout');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // User Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::patch('/users/{id}/activate', [AdminController::class, 'activateUser'])->name('users.activate');
        Route::patch('/users/{id}/deactivate', [AdminController::class, 'deactivateUser'])->name('users.deactivate');
        
        // Petugas Management
        Route::get('/petugas', [AdminController::class, 'petugasIndex'])->name('petugas.index');
        Route::get('/petugas/create', [AdminController::class, 'petugasCreate'])->name('petugas.create');
        Route::post('/petugas', [AdminController::class, 'petugasStore'])->name('petugas.store');
        Route::get('/petugas/{id}', [AdminController::class, 'petugasShow'])->name('petugas.show');
        Route::get('/petugas/{id}/edit', [AdminController::class, 'petugasEdit'])->name('petugas.edit');
        Route::patch('/petugas/{id}', [AdminController::class, 'petugasUpdate'])->name('petugas.update');
        Route::patch('/petugas/{id}/activate', [AdminController::class, 'petugasActivate'])->name('petugas.activate');
        Route::patch('/petugas/{id}/deactivate', [AdminController::class, 'petugasDeactivate'])->name('petugas.deactivate');
        Route::delete('/petugas/{id}', [AdminController::class, 'petugasDestroy'])->name('petugas.destroy');
        
        // Package Management
        Route::get('/packages', [AdminController::class, 'packages'])->name('packages');
        Route::get('/packages/create', [AdminController::class, 'createPackage'])->name('packages.create');
        Route::post('/packages', [AdminController::class, 'storePackage'])->name('packages.store');
        Route::get('/packages/{id}', [AdminController::class, 'showPackage'])->name('packages.show');
        Route::get('/packages/{id}/edit', [AdminController::class, 'editPackage'])->name('packages.edit');
        Route::patch('/packages/{id}', [AdminController::class, 'updatePackage'])->name('packages.update');
        Route::patch('/packages/{id}/activate', [AdminController::class, 'activatePackage'])->name('packages.activate');
        Route::patch('/packages/{id}/deactivate', [AdminController::class, 'deactivatePackage'])->name('packages.deactivate');
        Route::delete('/packages/{id}', [AdminController::class, 'destroyPackage'])->name('packages.destroy');
        
        // Booking Management
        Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
        Route::get('/bookings/{id}', [AdminController::class, 'showBooking'])->name('bookings.show');
        Route::post('/bookings/{id}/approve', [AdminController::class, 'approveBooking'])->name('bookings.approve');
        Route::post('/bookings/{id}/reject', [AdminController::class, 'rejectBooking'])->name('bookings.reject');
        
        // Reports
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/reports/export', [AdminController::class, 'exportReports'])->name('reports.export');
        Route::get('/reports/tickets/{id}', [AdminController::class, 'ticketReport'])->name('reports.tickets');
        Route::post('/reports/resend-ticket/{id}', [AdminController::class, 'resendTicket'])->name('reports.resend-ticket');
        
        // Ticket Download
        Route::get('/bookings/{id}/download-ticket', [AdminController::class, 'downloadTicketPDF'])->name('bookings.download-ticket');
        
        // Settings
        Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
        Route::post('/settings/test-email', [App\Http\Controllers\SettingController::class, 'testEmail'])->name('settings.test-email');
    });
    
    // Petugas Routes
    Route::prefix('petugas')->name('petugas.')->middleware('role:petugas')->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
        Route::get('/scanner', [PetugasController::class, 'scanner'])->name('scanner');
        Route::get('/scanner-enhanced', [PetugasController::class, 'scannerEnhanced'])->name('scanner.enhanced');
        Route::post('/scan-ticket', [PetugasController::class, 'scanTicket'])->name('scan.ticket');
        Route::get('/validated-tickets', [PetugasController::class, 'validatedTickets'])->name('validated.tickets');
        Route::get('/ticket/{id}', [PetugasController::class, 'ticketDetail'])->name('ticket.detail');
        Route::get('/daily-report', [PetugasController::class, 'dailyReport'])->name('daily.report');
        Route::post('/bulk-scan', [PetugasController::class, 'bulkScan'])->name('bulk.scan');
    });
    
    // Bendahara Routes
    Route::prefix('bendahara')->name('bendahara.')->middleware('role:bendahara')->group(function () {
        Route::get('/dashboard', [BendaharaController::class, 'dashboard'])->name('dashboard');
        Route::get('/transactions', [BendaharaController::class, 'transactions'])->name('transactions');
        Route::get('/reports', [BendaharaController::class, 'reports'])->name('reports');
        Route::post('/verify-report', [BendaharaController::class, 'verifyReport'])->name('verify.report');
    });
    
    // Owner Routes
    Route::prefix('owner')->name('owner.')->middleware('role:owner')->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
        Route::get('/reports', [OwnerController::class, 'reports'])->name('reports');
        Route::get('/package-analysis', [OwnerController::class, 'packageAnalysis'])->name('package.analysis');
    });
});

// Redirect based on role
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    $user = auth()->user();
    
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'petugas':
            return redirect()->route('petugas.dashboard');
        case 'bendahara':
            return redirect()->route('bendahara.dashboard');
        case 'owner':
            return redirect()->route('owner.dashboard');
        default:
            return redirect()->route('login');
    }
})->name('dashboard');
