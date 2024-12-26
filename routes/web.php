<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\StudentCourseScheduleController;

use App\Http\Controllers\AcademicResultController;

use App\Models\Course;
use App\Http\Controllers\CourseController;

use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',])->group(function ()
    {

    //sidebar
    //dashboard
    Route::get('/kict-dashboard', function () {
        $courses = Course::all();
        return view('admin/kict-dashboard', compact('courses'));
    })->name('kict-dashboard');

    Route::get('/teacher-dashboard', function () {
        return view('advisor/teacher-dashboard');
    })->name('teacher-dashboard');

    Route::get('/student-dashboard', function () {
        return view('student/student-dashboard');
    })->name('student-dashboard');

    //course
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/course/add-course', [CourseController::class, 'create'])->name('course.create');
        Route::post('/course/add-course', [CourseController::class, 'store'])->name('course.store');
        Route::get('/course/{course_code}/edit', [CourseController::class, 'edit'])->name('course.edit');
        Route::put('/course/{course_code}', [CourseController::class, 'update'])->name('course.update');
        Route::post('/course/delete/{course_code}', [CourseController::class, 'destroy'])->name('course.destroy');
    });

    Route::middleware(['role:admin|advisor|student'])->group(function () {
        Route::get('/course', [CourseController::class, 'index'])->name('course.index');
        Route::get('/course/{course}', [CourseController::class, 'show'])->name('course.show');
    });

    //course schedule
    Route::prefix('student-course-schedule')->group(function () {
        Route::get('/{studentId}', [StudentCourseScheduleController::class, 'index'])->name('student_course_schedule.index');
        Route::post('/{studentId}', [StudentCourseScheduleController::class, 'store'])->name('student_course_schedule.store');
        Route::delete('/student/{studentId}/course/{courseCode}/semester/{semesterId}', [StudentCourseScheduleController::class, 'destroy'])->name('student_course_schedule.destroy');
    });

    //academic result 
    Route::prefix('academic-result')->name('academic-result.')->group(function () {
        Route::get('{studentId}', [AcademicResultController::class, 'index'])->name('index'); // View academic results
        Route::post('{studentId}/store', [AcademicResultController::class, 'store'])->name('store'); // Save academic results
        Route::get('{studentId}/edit', [AcademicResultController::class, 'edit'])->name('edit'); // Edit academic results
        Route::put('{studentId}/update', [AcademicResultController::class, 'update'])->name('update'); // Update academic results
    });
    
    //Advising
    //student list
    Route::get('/advisor/student-list', [AdvisorController::class, 'studentList'])->name('advisor.student-list');
    Route::get('/advisor/student-profile/{student}', [AdvisorController::class, 'viewStudentProfile'])->name('advisor.view-student-profile')->middleware('role:advisor');
    Route::get('/advisor/student-schedule/{student}', [AdvisorController::class, 'viewStudentSchedule'])->name('advisor.student-schedule')->middleware('role:advisor');
    Route::get('/advisor/student-academic-result/{student}', [AdvisorController::class, 'viewStudentAcademicResult'])->name('advisor.student-academic-result')->middleware('role:advisor');
    Route::get('/appointments/latest/{student}', [AppointmentController::class, 'latestAppointmentByStudent'])->name('appointments.latest')->middleware('role:advisor'); 
    //appointment
    Route::middleware(['auth'])->group(function () {
        // Advisor Routes
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index')->middleware('role:advisor');
        Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit')->middleware('role:advisor');
        Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update')->middleware('role:advisor');
        // Student Routes
        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create')->middleware('role:student');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store')->middleware('role:student');
        Route::get('/appointments/mine', [AppointmentController::class, 'myAppointments'])->name('appointments.myAppointments')->middleware('role:student');
    });
    

    //taskbar
    //profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    //logout
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');
});
