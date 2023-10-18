<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ClassroomEnrollmentController;
use App\Http\Controllers\ClassroomSessionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CoursePrerequisiteController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentGradeController;
use App\Http\Controllers\TuitionPaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/pull', function () {
    $fetch = shell_exec('git fetch origin main');
    $pull = shell_exec('git pull origin main');
    return response()->json(compact('fetch', 'pull'));
});

Route::group(["middleware" => ['cache.data']], function () {


    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        });

        Route::get('/', function () {
            // $_routes = Route::getRoutes();
            // $routes = [];
            // foreach ($_routes as $key => $_route) {
            //     if ($_route->getName()) $routes[] = $_route->getName();
            // }
            // echo "<script>
            // var routes = " . json_encode($routes) . ";
            // console.log(routes)
            // </script>";
            // return;

            return view('dashboard');
        })->name('dashboard');

        Route::prefix('/')->group(function () {
            Route::resource('classroom', ClassroomController::class);
            Route::resource('classroom-enrollment', ClassroomEnrollmentController::class);
            Route::resource('classroom-session', ClassroomSessionController::class);
            Route::resource('course', CourseController::class)->names("course");
            Route::resource('course-prerequisite', CoursePrerequisiteController::class);
            Route::resource('faculty', FacultyController::class);
            Route::resource('lecturer', LecturerController::class);
            Route::resource('major', MajorController::class);
            Route::resource('room', RoomController::class);
            Route::resource('season', SeasonController::class);
            Route::resource('student', StudentController::class);
            Route::resource('student-attendance', StudentAttendanceController::class);
            Route::resource('student-grade', StudentGradeController::class);
            Route::resource('tuition-payment', TuitionPaymentController::class);
        });
    });
});
