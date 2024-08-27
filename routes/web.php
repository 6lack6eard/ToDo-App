<?php

use App\Http\Controllers\TaskController;
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

Route::get('/', [TaskController::class, 'index'])->name('index');
Route::get('/task-list-ajax/{type}', [TaskController::class, 'taskList'])->name('taskList.ajax');
Route::post('/add-task', [TaskController::class, 'addTask'])->name('task.add');
Route::get('/complete-task/{id}', [TaskController::class, 'completeTask'])->name('task.complete');
Route::get('/delete-task/{id}', [TaskController::class, 'deleteTask'])->name('task.delete');
