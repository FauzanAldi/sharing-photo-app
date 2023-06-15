<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'v1'], function () {

    foreach (File::glob(app_path(). '/Http/*/RoutesV1.php') as $route_file) {

        $array_file = explode("/",$route_file);

        $group = strtolower($array_file[count($array_file)-2]);

        Route::group(['middleware' => 'api', 'prefix' => $group], function () use ($route_file) {

            include_once $route_file;

        });

    }

});
