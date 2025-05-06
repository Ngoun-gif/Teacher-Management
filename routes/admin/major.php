<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\BMajorController;


Route::get('dashboard/major',[BMajorController::class,'index'])->name('major');

Route::get('/dashboard/major/fetechDataRecord',[BMajorController::class,'fetchMajorRecord'])->name('fetchMajorRecord');
Route::post('/dashboard/major/createMajorRecord',[BMajorController::class,'createMajorRecord'])->name('createMajorRecord');
Route::post('/dashboard/major/updateMajorRecord',[BMajorController::class,'updateMajorRecord'])->name('updateMajorRecord');
Route::delete('/dashboard/major/deletMajorRecord/{id}', [BMajorController::class, 'deleteMajorRecord'])->name('deleteMajorRecord');



