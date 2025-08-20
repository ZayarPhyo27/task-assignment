<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;



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



Route::get('/', function () {
    return view('auth/login',[
        'keyword' => "",
    ]);
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('tasks',[TaskController::class, 'index']);
    Route::get('tasks/create',[TaskController::class, 'create']);
    Route::get('tasks/{id}/edit',[TaskController::class, 'edit']);
    Route::post('tasks',[TaskController::class, 'store']);
    Route::put('tasks/{id}',[TaskController::class, 'update']);
    Route::delete('tasks/{id}',[TaskController::class, 'destroy']);

    Route::get('users',[UserController::class, 'index']);
    Route::get('users/create',[UserController::class, 'create']);
    Route::get('users/{id}/edit',[UserController::class, 'edit']);
    Route::post('users',[UserController::class, 'store']);
    Route::put('users/{id}',[UserController::class, 'update']);
    Route::delete('users/{id}',[UserController::class, 'destroy']);

    Route::get('products',[ProductController::class, 'index']);
    Route::get('products/create',[ProductController::class, 'create']);
    Route::get('products/{id}/edit',[ProductController::class, 'edit']);
    Route::post('products',[ProductController::class, 'store']);
    Route::put('products/{id}',[ProductController::class, 'update']);
    Route::delete('products/{id}',[ProductController::class, 'destroy']);


});

Route::get('orders',[OrderController::class, 'index']);
Route::get('orders/create',[OrderController::class, 'create']);
Route::get('orders/{id}/edit',[OrderController::class, 'edit']);
Route::post('orders',[OrderController::class, 'store']);
Route::put('orders/{id}',[OrderController::class, 'update']);
Route::delete('orders/{id}',[OrderController::class, 'destroy']);
Route::get('orders/{orders}',[OrderController::class, 'show']);


Route::get('orders/{id}/complete',[OrderController::class, 'complete']);
Route::get('orders/{id}/delivery',[OrderController::class, 'deliver']);


Route::get('tasks/doing/{id}',[TaskController::class, 'doingState']);
Route::get('tasks/complete/{id}',[TaskController::class, 'completeState']);



Auth::routes();

Route::get('website',[WebsiteController::class, 'index']);
Route::get('website/checkout',[WebsiteController::class, 'shoppingCart']);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
