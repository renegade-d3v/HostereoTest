<?php

use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\TagController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('posts/search/{value}', [PostController::class, 'search'])->name('search');
Route::apiResource('posts', PostController::class);
Route::apiResource('tags', TagController::class);
