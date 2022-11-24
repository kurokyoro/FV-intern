<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('todo.index');
});

Auth::routes();

Route::get('/home', function () {
    return redirect()->route('todo.index');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/todos', [App\Http\Controllers\TodoController::class, 'index'])->name('todo.index');
    Route::get('/todos/create', [App\Http\Controllers\TodoController::class, 'create'])->name('todo.create');
    Route::post('/todos/create', [App\Http\Controllers\TodoController::class, 'store'])->name('todo.store');
    Route::get('/todos/edit/{id}', [App\Http\Controllers\TodoController::class, 'edit'])->name('todo.edit');
    Route::put('/todos/edit/{id}', [App\Http\Controllers\TodoController::class, 'update']);
    Route::post('/todos/del/{id}', [App\Http\Controllers\TodoController::class, 'del'])->name('todo.delete');
    Route::get('/todos/status/{id}', [App\Http\Controllers\TodoController::class, 'status_check'])->name('todo.status');
    Route::post('/todos/status/{id}', [App\Http\Controllers\TodoController::class, 'status_change']);
    Route::get('/todos/category',[App\Http\Controllers\TodoController::class, 'category'])->name('todo.category');
    Route::post('/todos/category',[App\Http\Controllers\TodoController::class, 'create_category']);
    Route::get('/todos/task/{id}',[App\Http\Controllers\TodoController::class, 'detail'])->name('todo.detail');
    Route::post('/todos/{id}/comment',[App\Http\Controllers\TodoController::class, 'insertComment']);
    Route::get('/todos/category',[App\Http\Controllers\TodoController::class, 'categoryList'])->name('todo.category');
    Route::post('/todos/category/del/{id}',[App\Http\Controllers\TodoController::class, 'delCategory']);
    Route::get('/mail/send',[App\Http\Controllers\MailController::class, 'send'])->name('test.mail');
    Route::get('/todos/search/{id}',[App\Http\Controllers\TodoController::class, 'result'])->name('todo.result');
    Route::get("todos/trash/{id}",[App\Http\Controllers\TodoController::class, 'trash'])->name('todo.trash');
    Route::post("todos/trash/{id}",[App\Http\Controllers\TodoController::class, 'destroy'])->name('todo.destroy');
    Route::post("todos/restore/{id}",[App\Http\Controllers\TodoController::class, 'restore'])->name('todo.restore');

});