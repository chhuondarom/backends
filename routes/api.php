<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StaffController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/v1/staff/filter', [StaffController::class, 'search']);
Route::post('/v1/staff/add', [StaffController::class, 'store']);
Route::get('/v1/staff/get', [StaffController::class, 'index']);
Route::get('/v1/staff/get/{id}', [StaffController::class, 'show']);
Route::post('/v1/staff/update/{id}', [StaffController::class, 'edit']);
Route::delete('/v1/staff/delete/{id}', [StaffController::class, 'destroy']);



