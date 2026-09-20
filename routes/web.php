<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentTicketController;
use App\Http\Controllers\StaffTicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminFaqController;
use App\Http\Controllers\StudentFaqController;
use App\Http\Controllers\AdminNoticeController;
use App\Http\Controllers\StudentNoticeController;
use App\Http\Controllers\AdminKnowledgeController;
use App\Http\Controllers\StudentAiController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminDashboardController;
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
Route::get(
    '/student/ai-assistant',
    [StudentAiController::class, 'index']
)->name('student.ai');


// Ask AI Assistant
Route::post(
    '/student/ai-assistant',
    [StudentAiController::class, 'ask']
)->name('student.ai.ask');


Route::get(
    '/student/ai-history',
    [StudentAiController::class, 'history']
)->name('student.ai.history');


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
    Route::get(
    '/student/faqs',
    [StudentFaqController::class, 'index']
)->name('student.faqs');

    // Notices
    Route::get(
    '/student/notices',
    [StudentNoticeController::class, 'index']
)->name('student.notices');

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

    Route::get(
        '/admin/dashboard',
        [AdminDashboardController::class, 'index']
    )->name('admin.dashboard');
    // ========================================
// REPORTS
// ========================================

Route::get(
    '/admin/reports',
    [AdminReportController::class, 'index']
)->name('admin.reports');

// ========================================
// KNOWLEDGE BASE
// ========================================

Route::get(
    '/admin/knowledge',
    [AdminKnowledgeController::class, 'index']
)->name('admin.knowledge.index');


Route::get(
    '/admin/knowledge/create',
    [AdminKnowledgeController::class, 'create']
)->name('admin.knowledge.create');


Route::post(
    '/admin/knowledge',
    [AdminKnowledgeController::class, 'store']
)->name('admin.knowledge.store');


Route::get(
    '/admin/knowledge/{article}/edit',
    [AdminKnowledgeController::class, 'edit']
)->name('admin.knowledge.edit');


Route::put(
    '/admin/knowledge/{article}',
    [AdminKnowledgeController::class, 'update']
)->name('admin.knowledge.update');


Route::patch(
    '/admin/knowledge/{article}/status',
    [AdminKnowledgeController::class, 'toggleStatus']
)->name('admin.knowledge.status');


Route::delete(
    '/admin/knowledge/{article}',
    [AdminKnowledgeController::class, 'destroy']
)->name('admin.knowledge.destroy');










Route::get(
    '/admin/notices',
    [AdminNoticeController::class, 'index']
)->name('admin.notices.index');


Route::get(
    '/admin/notices/create',
    [AdminNoticeController::class, 'create']
)->name('admin.notices.create');


Route::post(
    '/admin/notices',
    [AdminNoticeController::class, 'store']
)->name('admin.notices.store');


Route::get(
    '/admin/notices/{notice}/edit',
    [AdminNoticeController::class, 'edit']
)->name('admin.notices.edit');


Route::put(
    '/admin/notices/{notice}',
    [AdminNoticeController::class, 'update']
)->name('admin.notices.update');


Route::patch(
    '/admin/notices/{notice}/status',
    [AdminNoticeController::class, 'toggleStatus']
)->name('admin.notices.status');


Route::delete(
    '/admin/notices/{notice}',
    [AdminNoticeController::class, 'destroy']
)->name('admin.notices.destroy');














    


    // ========================================
// CATEGORY MANAGEMENT
// ========================================

Route::get(
    '/admin/categories',
    [AdminCategoryController::class, 'index']
)->name('admin.categories.index');


Route::get(
    '/admin/categories/create',
    [AdminCategoryController::class, 'create']
)->name('admin.categories.create');


Route::post(
    '/admin/categories',
    [AdminCategoryController::class, 'store']
)->name('admin.categories.store');


Route::get(
    '/admin/categories/{category}/edit',
    [AdminCategoryController::class, 'edit']
)->name('admin.categories.edit');


Route::put(
    '/admin/categories/{category}',
    [AdminCategoryController::class, 'update']
)->name('admin.categories.update');


Route::patch(
    '/admin/categories/{category}/status',
    [AdminCategoryController::class, 'toggleStatus']
)->name('admin.categories.status');


Route::delete(
    '/admin/categories/{category}',
    [AdminCategoryController::class, 'destroy']
)->name('admin.categories.destroy');



// ========================================
// FAQ MANAGEMENT
// ========================================

Route::get(
    '/admin/faqs',
    [AdminFaqController::class, 'index']
)->name('admin.faqs.index');


Route::get(
    '/admin/faqs/create',
    [AdminFaqController::class, 'create']
)->name('admin.faqs.create');


Route::post(
    '/admin/faqs',
    [AdminFaqController::class, 'store']
)->name('admin.faqs.store');


Route::get(
    '/admin/faqs/{faq}/edit',
    [AdminFaqController::class, 'edit']
)->name('admin.faqs.edit');


Route::put(
    '/admin/faqs/{faq}',
    [AdminFaqController::class, 'update']
)->name('admin.faqs.update');


Route::patch(
    '/admin/faqs/{faq}/status',
    [AdminFaqController::class, 'toggleStatus']
)->name('admin.faqs.status');


Route::delete(
    '/admin/faqs/{faq}',
    [AdminFaqController::class, 'destroy']
)->name('admin.faqs.destroy');


    // STUDENTS

    Route::get(
        '/admin/students',
        [AdminUserController::class, 'students']
    )->name('admin.students');


    // STAFF

    Route::get(
        '/admin/staff',
        [AdminUserController::class, 'staff']
    )->name('admin.staff');


    Route::get(
        '/admin/staff/create',
        [AdminUserController::class, 'createStaff']
    )->name('admin.staff.create');


    Route::post(
        '/admin/staff',
        [AdminUserController::class, 'storeStaff']
    )->name('admin.staff.store');


    // EDIT USER

    Route::get(
        '/admin/users/{user}/edit',
        [AdminUserController::class, 'edit']
    )->name('admin.users.edit');


    Route::put(
        '/admin/users/{user}',
        [AdminUserController::class, 'update']
    )->name('admin.users.update');


    // STATUS

    Route::patch(
        '/admin/users/{user}/status',
        [AdminUserController::class, 'toggleStatus']
    )->name('admin.users.status');


    // DELETE

    Route::delete(
        '/admin/users/{user}',
        [AdminUserController::class, 'destroy']
    )->name('admin.users.destroy');

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