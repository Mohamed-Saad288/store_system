<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\GovernorateController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;
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

/* Start Login */
Route::post("dashboard/v1/login", [AuthController::class, "login"])->name("login");
/* End Login */

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


        /* start product*/
        Route::controller(ProductController::class)->group(function () {
            Route::post("store_product","store_product");
            Route::post("update_product","update_product");
            Route::post("fetch_products","fetch_products");
            Route::post("show_product","show_product");
            Route::post("delete_product","delete_product");
        });
        /* end product */

        /* start order*/
        Route::controller(App\Http\Controllers\Dashboard\OrderController::class)->group(function () {
            Route::post("update_order","update_order");
            Route::post("fetch_orders","fetch_orders");
            Route::post("show_order","show_order");
            Route::post("delete_order","delete_order");
        });
        /* end order */
    });



//  User Routes
Route::group(
    [
        'prefix' => "website/v1/",
        "middleware" => ["api"],
    ],
    function () {

        /* start order*/
        Route::controller(App\Http\Controllers\Website\OrderController::class)->group(function () {
            Route::post("store_order","store_order");
        });
        /* end order */

    });
