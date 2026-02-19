<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;

Route::get('/books', [BookController::class, 'index']);
Route::get('/loans/history', [LoanController::class, 'history']);