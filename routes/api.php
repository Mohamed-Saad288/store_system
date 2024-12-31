<?php

use App\Http\Controllers\Dashboard\AuthController;
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


 //  Admin Routes
Route::group(
    [
        'prefix' => "dashboard/v1/",
        "middleware" => ["api"],
    ],
    function () {
    });


/* Start Login */
    Route::post("dashboard/v1/login", [AuthController::class, "login"])->name("login");
/* End Login */
