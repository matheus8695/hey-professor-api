<?php

use App\Http\Controllers\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('user', fn (Request $request) => $request->user());

#region Questions
Route::get('my-questions/{status}', Question\MyController::class)->name('my-questions');
Route::get('questions', Question\IndexController::class)->name('questions.index');
Route::post('questions', Question\StoreController::class)->name('questions.store');
Route::put('questions/{question}', Question\UpdateController::class)->name('questions.update');
Route::delete('question/{question}', Question\DeleteController::class)->name('questions.delete');
Route::delete('question/{question}/archive', Question\ArchiveController::class)->name('questions.archive');
Route::put('questions/{question}/restore', Question\RestoreController::class)->name('questions.restore');
Route::put('questions/{question}/publish', Question\PublishController::class)->name('questions.publish');
#endregion
