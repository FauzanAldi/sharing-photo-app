<?php

use App\Http\UploadService\UploadServiceController;

Route::post('/image/{typeupload}', [UploadServiceController::class, 'uploadImage']);
Route::post('/file/{typeupload}', [UploadServiceController::class, 'uploadFile']);
