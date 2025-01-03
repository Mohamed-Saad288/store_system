<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\GovernorateController;
use App\Http\Controllers\Dashboard\SettingController;
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


 //  Admin Routes
Route::group(
    [
        'prefix' => "dashboard/v1/",
        "middleware" => ["auth:sanctum"],
    ],
    function () {
        /* start governorate*/
        Route::controller(GovernorateController::class)->group(function () {
            Route::post("store_governorate","store_governorate");
            Route::post("update_governorate","update_governorate");
            Route::post("fetch_governorates","fetch_governorates");
            Route::post("show_governorate","show_governorate");
            Route::post("delete_governorate","delete_governorate");
        });
        /* end governorate */

        /* start setting*/
        Route::controller(SettingController::class)->group(function () {
            Route::post("store_setting","store_setting");
            Route::post("update_setting","update_setting");
            Route::post("fetch_settings","fetch_settings");
            Route::post("show_setting","show_setting");
            Route::post("delete_setting","delete_setting");
        });
        /* end setting */
    });


/* Start Login */
    Route::post("dashboard/v1/login", [AuthController::class, "login"])->name("login");
/* End Login */
