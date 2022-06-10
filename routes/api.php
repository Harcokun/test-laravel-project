<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookTypeController;
use App\Http\Controllers\TelephoneController;
use App\Http\Controllers\AuthController;

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

// Route for Store
Route::middleware(['auth:api'])->group(function() {
    Route::get('stores', [StoreController::class, 'index'])->withoutMiddleware(['auth:api']);
    Route::post('stores', [StoreController::class, 'store']);
    Route::get('stores/{id}', [StoreController::class, 'show'])->withoutMiddleware(['auth:api']);
    Route::put('stores/{id}', [StoreController::class, 'update']);
    Route::delete('stores/{id}', [StoreController::class, 'destroy']);
});

//Route for User
Route::middleware(['auth:api'])->group(function() {
    Route::apiResource('users', UserController::class);
});

//Route for BookType
Route::apiResource('book_types', BookTypeController::class);

//Route for Book
Route::middleware(['auth:api'])->group(function() {
    Route::apiResource('books', BookController::class);
});

//Route for Telephone
Route::apiResource('telephones', telephoneController::class);

//Route for authentication
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});