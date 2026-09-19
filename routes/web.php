<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentTicketController;
use App\Http\Controllers\StaffTicketController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


// ========================================
// HOME
// ========================================

Route::get('/', function () {
    return view('welcome');
});


// ========================================
// MAIN DASHBOARD REDIRECT
// ========================================

Route::get('/dashboard', function () {

    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'staff') {
        return redirect()->route('staff.dashboard');
    }

    return redirect()->route('student.dashboard');

})->middleware('auth')->name('dashboard');


// ========================================
// STUDENT ROUTES
// ========================================

Route::middleware(['auth', 'role:student'])->group(function () {

    // Student Dashboard
   Route::get(
    '/student/dashboard',
    [DashboardController::class, 'student']
)->name('student.dashboard');

    // AI Assistant
    Route::get('/student/ai-assistant', function () {
        return view('student.ai');
    })->name('student.ai');


    // Ticket List
    Route::get(
        '/student/tickets',
        [StudentTicketController::class, 'index']
    )->name('student.tickets');


    // Create Ticket Page
    Route::get(
        '/student/tickets/create',
        [StudentTicketController::class, 'create']
    )->name('student.tickets.create');


    // Save Ticket
    Route::post(
        '/student/tickets',
        [StudentTicketController::class, 'store']
    )->name('student.tickets.store');


    // View Ticket
    Route::get(
        '/student/tickets/{ticket}',
        [StudentTicketController::class, 'show']
    )->name('student.tickets.show');


    // Student Reply
    Route::post(
        '/student/tickets/{ticket}/reply',
        [StudentTicketController::class, 'reply']
    )->name('student.tickets.reply');


    // FAQs
    Route::get('/student/faqs', function () {
        return view('student.faqs');
    })->name('student.faqs');


    // Notices
    Route::get('/student/notices', function () {
        return view('student.notices');
    })->name('student.notices');

});


// ========================================
// STAFF ROUTES
// ========================================

Route::middleware(['auth', 'role:staff'])->group(function () {

    // Staff Dashboard
   Route::get(
    '/staff/dashboard',
    [DashboardController::class, 'staff']
)->name('staff.dashboard');

    // Ticket List
    Route::get(
        '/staff/tickets',
        [StaffTicketController::class, 'index']
    )->name('staff.tickets');


    // View Ticket
    Route::get(
        '/staff/tickets/{ticket}',
        [StaffTicketController::class, 'show']
    )->name('staff.tickets.show');


    // Assign Ticket
    Route::patch(
        '/staff/tickets/{ticket}/assign',
        [StaffTicketController::class, 'assign']
    )->name('staff.tickets.assign');


    // Update Ticket Status
    Route::patch(
        '/staff/tickets/{ticket}/status',
        [StaffTicketController::class, 'updateStatus']
    )->name('staff.tickets.status');


    // Staff Reply
    Route::post(
        '/staff/tickets/{ticket}/reply',
        [StaffTicketController::class, 'reply']
    )->name('staff.tickets.reply');

});


// ========================================
// ADMIN ROUTES
// ========================================

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

});


// ========================================
// PROFILE ROUTES
// ========================================

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});


// ========================================
// AUTHENTICATION ROUTES
// ========================================

require __DIR__.'/auth.php';