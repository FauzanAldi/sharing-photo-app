<?php

use App\Http\Photos\PhotosController;

Route::get('/', [PhotosController::class, 'index']);
Route::get('/{id}', [PhotosController::class, 'show']);
Route::post('/', [PhotosController::class, 'store']);
Route::put('/{id}', [PhotosController::class, 'update']);
Route::delete('/{id}', [PhotosController::class, 'destroy']);

Route::post('/{id}/like', [PhotosController::class, 'likePhoto']);
Route::post('/{id}/unlike', [PhotosController::class, 'dislikePhoto']);