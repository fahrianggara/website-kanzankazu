<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Categories
Route::get('/category/index', [CategoryController::class, 'index']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Categories
    Route::get('/category/select', [CategoryController::class, 'select']);

    // Logout
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);
