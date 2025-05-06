<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\BTeacherController;


Route::get('dashboard/teacher',[BTeacherController::class,'index'])->name('teacher');
Route::get('dashboard/teacher1',[BTeacherController::class,'index1'])->name('teacher');

Route::get('/dashboard/teacher/fetchDataRecord',[BTeacherController::class,'fetchTeacherRecord'])->name('fetchTeacherRecord');
Route::post('/dashboard/teacher/createTeacherRecord',[BTeacherController::class,'createTeacherRecord'])->name('createTeacherRecord');
Route::delete('/dashboard/teacher/deleteTeacherRecord/{id}', [BTeacherController::class, 'deleteTeacherRecord'])->name('deleteTeacherRecord');
Route::post('/dashboard/teacher/updateTeacherRecord', [BTeacherController::class, 'updateTeacherRecord'])->name('updateTeacherRecord');



