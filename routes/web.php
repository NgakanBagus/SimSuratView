<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PositionController;

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/', [MessageController::class, 'showAll']);

Route::get('/message/{message}', [MessageController::class, 'show']);

Route::get('/create-message', [MessageController::class, 'create']);

Route::post('/message', [MessageController::class, 'store'])->name('message.store');

Route::get('/edit-message/{message}', [MessageController::class, 'edit']);

Route::put('/message/{id}', [MessageController::class, 'update'])->name('message.update');

Route::delete('/delete-message', [MessageController::class, 'delete'])->name('message.delete');

Route::get('/upload', [MessageController::class, 'create'])->name('upload');
Route::post('/upload', [MessageController::class, 'store'])->name('store');
Route::get('/pdf/{id}', [MessageController::class, 'show'])->name('show');

Route::get('/pdf/{pdfId}/disposisi/create', [MessageController::class, 'createDisposisi'])->name('createDisposisi');
Route::post('/pdf/{pdfId}/disposisi', [MessageController::class, 'storeDisposisi'])->name('storeDisposisi');

Route::get('/disposisi/{id}/edit', [MessageController::class, 'editDisposisi'])->name('editDisposisi');
Route::put('/disposisi/{id}', [MessageController::class, 'updateDisposisi'])->name('updateDisposisi');
Route::delete('/disposisi/{id}', [MessageController::class, 'deleteDisposisi'])->name('deleteDisposisi');
