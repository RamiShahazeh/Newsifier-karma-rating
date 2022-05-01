<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::prefix('v1')->group(function() {
    Route::post('user/karma-position', [UserController::class,'post_user_position'])->name('post_user_positions');
    Route::get('user/karma-position', [UserController::class,'get_user_position'])->name('get_user_positions');
});

Route::fallback(function () {
    return redirect()->route('get_user_positions');
});