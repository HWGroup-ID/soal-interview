<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;


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

// book routes
Route::get("book", [BookController::class,"index"]);
Route::get("book/{id}", [BookController::class,"show"]);
Route::post("book", [BookController::class,"store"]);
Route::put("book/{id}", [BookController::class,"update"]);
Route::delete("book/{id}", [BookController::class,"destroy"]);

// category routes
Route::get("categories", [CategoryController::class,"index"]);
Route::get("categories/{id}", [CategoryController::class,"show"]);
Route::post("categories", [CategoryController::class,"store"]);
Route::put("categories/{id}", [CategoryController::class,"update"]);
Route::delete("categories/{id}", [CategoryController::class,"destroy"]);

// loan routes
Route::get("loan/{id}", [LoanController::class,"userLoans"]);
Route::post("loan/borrow", [LoanController::class,"borrow"]);
Route::post("loan/return", [LoanController::class,"return"]);
