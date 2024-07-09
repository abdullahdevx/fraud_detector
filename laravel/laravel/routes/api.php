<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\userController;
use App\Http\Controllers\adminController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [authController::class, 'logoutUser']);
    Route::put('/editadmin', [authController::class, 'editEntity']);
    Route::get('/showadmin', [authController::class, 'showEntity(id)']);
    Route::post('/addreview', [userController::class, 'addReview']);
    Route::get('/accountdata', [userController::class, 'showAccountData']);
    Route::post('/changepicture', [userController::class, 'changePicture']);
    Route::get('/checkrole', [adminController::class, 'checkRole']);

});

    Route::post('/deleteadmin/{id}', [adminController::class, 'deleteEntity']);
    Route::get('/entitydata/{id}', [userController::class, 'showEntity']);
    Route::post('/search', [userController::class, 'search']);
    Route::post('/createadmin', [adminController::class, 'createEntity']);
    Route::get('/home', [userController::class, 'fetchData']);
    Route::post('/login', [authController::class, 'login']);
    Route::post('/register', [authController::class, 'register']);