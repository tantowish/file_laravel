<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", [PostController::class,"index"])->name("post.index");
Route::get("/create", [PostController::class,"create"])->name("post.create");
Route::post("/", [PostController::class,"store"])->name("post.store");
Route::get("/{id}/edit", [PostController::class,"edit"])->name("post.edit");
Route::put("/{id}", [PostController::class,"update"])->name("post.update");

