<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\BCourseController;


Route::get('dashboard/course',[BCourseController::class,'index'])->name('course');

Route::get('/dashboard/course/fetechDataRecord',[BCourseController::class,'fetchCourseRecord'])->name('fetchCourseRecord');
Route::post('/dashboard/course/createCourseRecord',[BCourseController::class,'createCourseRecord'])->name('createCourseRecord');
Route::delete('/dashboard/course/deleteCourseRecord/{id}', [BCourseController::class, 'deleteCourseRecord'])->name('deleteCourseRecord');
Route::post('/dashboard/course/updateCourseRecord',[BCourseController::class,'updateCourseRecord'])->name('updateCourseRecord');



