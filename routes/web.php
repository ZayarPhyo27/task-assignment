<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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
   
});

Route::get('tasks/doing/{id}',[TaskController::class, 'doingState']);
Route::get('tasks/complete/{id}',[TaskController::class, 'completeState']);

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
