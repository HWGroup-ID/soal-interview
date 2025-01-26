<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;

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

Route::apiResource('categories', CategoryController::class);
Route::apiResource('books', BookController::class);

Route::post('/borrows/{id}/return', [BorrowController::class, 'returnBook']);
Route::get('/borrows/borrowed', [BorrowController::class, 'borrowedBooks']);
Route::apiResource('borrows', BorrowController::class)->except(['store', 'update', 'destroy']);
