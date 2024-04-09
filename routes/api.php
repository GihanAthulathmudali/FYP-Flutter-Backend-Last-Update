<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Cropscontroller;
use App\Http\Controllers\UrlController;

/*ute;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Cropscontroller;


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

Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user-data', [LoginController::class, 'getUserData']);



Route::post('/cropsstore', [Cropscontroller::class, 'cropsstore']);
Route::post('/getCropsWithSimilarSoilType', [Cropscontroller::class, 'getCropsWithSimilarSoilType']);
Route::post('/storedisease', [Cropscontroller::class, 'storedisease']);
Route::post('/diseasesgetall', [Cropscontroller::class, 'diseasesgetall']);
Route::post('/diseasesgetiD', [Cropscontroller::class, 'diseasesgetiD']);
Route::post('/receive-url', [UrlController::class, 'store']);
Route::get('/get-url', [UrlController::class, 'get']);



