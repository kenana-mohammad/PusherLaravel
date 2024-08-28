<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;

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
Route::controller(AuthController::class)->group(function(){
    Route::post('register','Register');
    Route::post('login','login');
    Route::post('logout','logout')->middleware('auth');

    });

    //chat
    Route::get('/chat/{user_id}',[ChatController::class,'chatform'])->middleware('auth');
    Route::post('/send-message/{user_id}',[ChatController::class,'sendMessage'])->middleware('auth');