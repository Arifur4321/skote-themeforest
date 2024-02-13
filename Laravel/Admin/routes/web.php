<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes(['verify' => true]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

// customers route
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers.list');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');



 
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

// routes/web.php

// routes/web.php or routes/api.php
 
Route::post('/save-project', [App\Http\Controllers\ProjectController::class, 'saveProject']);

// for edit 
//Route::post('/edit-project/{id}', 'ProjectController@editProject')->name('edit-project');

//dd(\Route::getRoutes());

// routes/web.php
Route::get('/arifurtable', [App\Http\Controllers\ProjectController::class, 'showProjects']);


//Route::get('/arifurcontract', [App\Http\Controllers\ProjectController::class, 'showProjects']);

 
use App\Http\Controllers\ArifurContractController;

Route::get('/arifurcontract', [ App\Http\Controllers\ArifurContractController::class, 'show'])->name('arifurcontract.show');
 
Route::post('/save', [App\Http\Controllers\ArifurContractController::class, 'save']);

Route::post('/arifurcontract/autosave', [App\Http\Controllers\ArifurContractController::class, 'autosave'])->name('arifurcontract.autosave');


//Route::get('/arifurcontract/{id}/edit', [App\Http\Controllers\ArifurContractController::class, 'edit'])->name('arifurcontract.edit');


//Route::post('/arifurcontract/{id}/update', [App\Http\Controllers\ArifurContractController::class, 'update'])->name('arifurcontract.update');





Route::get('list',[App\Http\Controllers\MemberController::class,'show']);

//Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'showProjects'])->name('projects.index');

// for edit

Route::post('/update-project/{id}', [App\Http\Controllers\ProjectController::class, 'updateProject']);



// for delete
Route::get('/delete/{id}', 'App\Http\Controllers\ProjectController@deleteProject');
//Route::get('delete/(id)',ProjectController@deleteProject');
 


// to make work
Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
 
