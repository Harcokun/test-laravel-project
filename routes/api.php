<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookTypeController;

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

// Route for Store
Route::get('/stores', [StoreController::class, 'index']);
Route::post('/stores', [StoreController::class, 'store']);
Route::get('/stores/{id}', [StoreController::class, 'show']);
Route::put('/stores/{id}', [StoreController::class, 'update']);
Route::delete('/stores/{id}', [StoreController::class, 'destroy']);

//Route for User
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

//Route for BookType
Route::get('/book_types', [BookTypeController::class, 'index']);
Route::post('/book_types', [BookTypeController::class, 'store']);
Route::get('/book_types/{id}', [BookTypeController::class, 'show']);
Route::put('/book_types/{id}', [BookTypeController::class, 'update']);
Route::delete('/book_types/{id}', [BookTypeController::class, 'destroy']);

//Route for Book
Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);

//Route for Telephone
Route::get('/telephones', [TelephoneController::class, 'index']);
Route::post('/telephones', [TelephoneController::class, 'store']);
Route::get('/telephones/{id}', [TelephoneController::class, 'show']);
Route::put('/telephones/{id}', [TelephoneController::class, 'update']);
Route::delete('/telephones/{id}', [TelephoneController::class, 'destroy']);