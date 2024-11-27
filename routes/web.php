<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CourseController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',])->group(function () 
    {
    //taskbar
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    //sidebar
    //dashboard
    Route::get('/kict-dashboard', function () {
        return view('admin/kict-dashboard');
    })->name('kict-dashboard');

    Route::get('/teacher-dashboard', function () {
        return view('advisor/teacher-dashboard');
    })->name('teacher-dashboard');

    Route::get('/dashboard', function () {
        return view('student/student-dashboard');
    })->name('dashboard');

    //students
    Route::get('/students', function () {
        return view('students');
    })->name('students');

    Route::get('/student-details', function () {
        return view('student-details');
    })->name('student-details');

    Route::get('/add-student', function () {
        return view('add-student');
    })->name('add-student');

    Route::get('/edit-student', function () {
        return view('edit-student');
    })->name('edit-student');

    // Route to view add course form
    Route::get('/add-course', function () {
        return view('course.add-course');
    })->name('add-course');

    // Admin-only routes for managing courses
    Route::middleware(['role:admin'])->group(function () {
    Route::get('/course/add-course', [CourseController::class, 'create'])->name('course.create'); // Changed to add-course
    Route::post('/course/store', [CourseController::class, 'store'])->name('course.store');
    Route::get('/course/{course}/edit', [CourseController::class, 'edit'])->name('course.edit');
    Route::put('/course/{course}', [CourseController::class, 'update'])->name('course.update');
    Route::delete('/course/{course}', [CourseController::class, 'destroy'])->name('course.destroy');
    });

    // Routes for viewing courses (accessible to admin, advisor, and student)
    Route::middleware(['role:admin|advisor|student'])->group(function () {
    Route::get('/course/index-course', [CourseController::class, 'index'])->name('course.index'); // Changed to index-course
    Route::get('/course/{course}', [CourseController::class, 'show'])->name('course.show');
    });

    //logout
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');
});