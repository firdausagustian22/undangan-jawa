<?php

use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\CheckinController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Admin\RsvpController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\WishController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeddingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Wedding Invitation Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [WeddingController::class, 'index'])->name('invitation.home');
Route::get('/undangan', [WeddingController::class, 'index'])->name('invitation.index');
Route::get('/undangan/{token}', [WeddingController::class, 'showWithToken'])->name('invitation.token');

Route::post('/api/rsvp', [WeddingController::class, 'storeRsvp'])->name('invitation.rsvp');
Route::post('/api/wish', [WeddingController::class, 'storeWish'])->name('invitation.wish');
Route::get('/api/wishes', [WeddingController::class, 'getWishes'])->name('invitation.wishes');
Route::get('/event/{event}/calendar.ics', [WeddingController::class, 'downloadIcs'])->name('invitation.ics');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Protected Admin Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Guests Management
    Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::post('/guests', [GuestController::class, 'store'])->name('guests.store');
    Route::put('/guests/{guest}', [GuestController::class, 'update'])->name('guests.update');
    Route::delete('/guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');
    Route::get('/guests/export', [GuestController::class, 'exportCsv'])->name('guests.export');
    Route::post('/guests/import', [GuestController::class, 'importCsv'])->name('guests.import');

    // RSVP Management
    Route::get('/rsvps', [RsvpController::class, 'index'])->name('rsvps.index');
    Route::put('/rsvps/{rsvp}', [RsvpController::class, 'update'])->name('rsvps.update');
    Route::get('/rsvps/export', [RsvpController::class, 'exportCsv'])->name('rsvps.export');

    // Hari-H Attendance Check-In Desk
    Route::get('/checkin', [CheckinController::class, 'index'])->name('checkin.index');
    Route::get('/checkin/search', [CheckinController::class, 'search'])->name('checkin.search');
    Route::post('/checkin/process', [CheckinController::class, 'process'])->name('checkin.process');
    Route::delete('/checkin/{checkin}', [CheckinController::class, 'undo'])->name('checkin.undo');

    // Wishes Moderation
    Route::get('/wishes', [WishController::class, 'index'])->name('wishes.index');
    Route::put('/wishes/{wish}/status', [WishController::class, 'updateStatus'])->name('wishes.status');
    Route::delete('/wishes/{wish}', [WishController::class, 'destroy'])->name('wishes.destroy');

    // Wedding Content & Events Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/wedding', [SettingController::class, 'updateWedding'])->name('settings.wedding');
    Route::post('/settings/couple', [SettingController::class, 'updateCouple'])->name('settings.couple');
    Route::put('/settings/events/{event}', [SettingController::class, 'updateEvent'])->name('settings.events.update');

    // Security Audit Logs
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.index');
});
