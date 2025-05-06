<?php

use App\Http\Controllers\frontend\AboutController;
use App\Http\Controllers\frontend\ContactController;
use App\Http\Controllers\frontend\CourseController;
use App\Http\Controllers\frontend\EventController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\PricingController;
use App\Http\Controllers\frontend\TrainerController;
use App\Http\Controllers\ProfileController;
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

//Frontend block
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/courses', [CourseController::class, 'index'])->name('contact');
Route::get('/event', [EventController::class, 'index'])->name('event');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::get('/contact', [TrainerController::class, 'index'])->name('contact');
Route::get('/trainers', [TrainerController::class, 'index'])->name('trainer');




//backend block

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard',[\App\Http\Controllers\backend\BDashboardController::class,'index'])->name('dashboard');

    include __DIR__.'/admin/teacher.php';
    include __DIR__.'/admin/major.php';
    include __DIR__.'/admin/subject.php';
    include __DIR__.'/admin/course.php';

});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
