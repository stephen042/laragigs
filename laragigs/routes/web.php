<?php

use App\Models\Listing;
use PhpParser\Node\Expr\List_;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// all Listings
Route::get('/', [ListingController::class, 'index']);

// show create Listings
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// store listing data to database
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');


// edit listing data in database
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'delete'])->middleware('auth');

// Manage listing
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// show single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show Register Page/Create form 
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create new user
Route::post('/users', [UserController::class, 'store']);

// Show Login Form 
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// authenticate users
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// log user out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
