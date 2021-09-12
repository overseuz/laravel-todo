<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskListController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Списки задач
Route::get('/task_lists', [TaskListController::class, 'index'])->name('task_lists.index');
Route::post('/add_task_list',[TaskListController::class, 'store'])->name('add.task_list');
Route::get('/get_task_lists', [TaskListController::class, 'getTaskLists'])->name('get.task_lists');
Route::post('/get_task_list_details', [TaskListController::class, 'getTaskListDetails'])->name('get.task_list_details');
Route::post('/update_task_list',[TaskListController::class, 'update'])->name('update.task_list');
Route::post('/delete_task_list',[TaskListController::class, 'destroy'])->name('delete.task_list');

// Задачи
Route::post('/add_task',[TaskController::class, 'store'])->name('add.task');
Route::get('/get_tasks/{task_list_id}', [TaskController::class, 'getTasks'])->name('get.tasks');
Route::post('/get_task_details', [TaskController::class, 'getTaskDetails'])->name('get.task_details');
Route::post('/update_task',[TaskController::class, 'update'])->name('update.task');
Route::post('/delete_task',[TaskController::class, 'destroy'])->name('delete.task');