<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;

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

Route::get('/allRole',[RoleController::class,'allRole']);
Route::get('/allUsers',[UserController::class,'allUsers']);
// -------------------------------------------------------

Route::post('addRole',[RoleController::class,'addRole']);
Route::post('editRole',[RoleController::class,'editRole']);
Route::post('deleteRole',[RoleController::class,'deleteRole']);
Route::post('addUser',[UserController::class,'create']);
Route::get('checkEmail',[UserController::class,'checkEmail']);

