<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\TeamLeaderController;

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
})->middleware('guest');

Auth::routes();

Route::group(['middleware' => 'auth'],function(){
    Route::group(['middleware' => 'admin','prefix' => 'admin','as' => 'admin.'],function(){
        Route::resource('roles',RoleController::class);
        Route::resource('teams',TeamController::class);
        Route::resource('users',UserController::class);
    });
    Route::group(['middleware' => 'team-leader','prefix' => 'team-leader','as' => 'team-leader.'],function(){
        Route::resource('projects',ProjectController::class);
        Route::resource('tasks',TaskController::class);
        Route::get('developers',[TeamLeaderController::class,'developerList'])->name('developers.index');
    });
    Route::group(['middleware' => 'developer','prefix' => 'developer','as' => 'developer.'],function(){
        Route::get('tasks',[DeveloperController::class,'tasks'])->name('tasks.index');
        Route::get('kanban',[DeveloperController::class,'kanban'])->name('tasks.kanban');
        Route::post('developer_todo_task',[DeveloperController::class,'getTaskData'])->name('developer_todo_task');
        Route::post('change_task_status',[DeveloperController::class,'changeTaskStatus'])->name('change_task_status');
        Route::get('projects',[DeveloperController::class,'developerProjects'])->name('projects.list');
        Route::get('projects/details/{id}',[DeveloperController::class,'projectDetails'])->name('project.details');
        Route::post('task/create',[DeveloperController::class,'taskCreate'])->name('tasks.create');
        Route::post('task/delete',[DeveloperController::class,'taskDelete'])->name('task.delete');
        Route::get('weather',[DeveloperController::class,'weather']);
    });


});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
