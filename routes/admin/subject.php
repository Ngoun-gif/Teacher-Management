<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\BSubjectController;


Route::get('dashboard/subject',[BSubjectController::class,'index'])->name('subject');

Route::get('/dashboard/subject/fetechDataRecord',[BSubjectController::class,'fetchSubjectRecord'])->name('fetchSubjectRecord');
Route::post('/dashboard/subject/createSubjectRecord',[BSubjectController::class,'createSubjectRecord'])->name('createSubjectRecord');
Route::post('/dashboard/subject/updateSubjectRecord',[BSubjectController::class,'updateSubjectRecord'])->name('updateSubjectRecord');
Route::delete('/dashboard/subject/deletSubjectRecord/{id}', [BSubjectController::class, 'deleteSubjectRecord'])->name('deleteSubjectRecord');



