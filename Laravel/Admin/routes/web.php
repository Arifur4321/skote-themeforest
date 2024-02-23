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

// for Contractlist page  in office -----------------

// for the edit-contract-page
 

Route::get('/edit-contract-list/{id}', [App\Http\Controllers\EditContractListController::class, 'edit']);
 
Route::get('/edit-contract-list', [App\Http\Controllers\EditContractListController::class, 'showvariable']);
 
Route::post('/edit-contract-list/update', [App\Http\Controllers\EditContractListController::class, 'updateContract'])->name('edit-contract-list.update');



Route::get('/Contract-List', [App\Http\Controllers\ContractController::class, 'index'])->name('contracts.index');

Route::post('/update-variable/{id}', [App\Http\Controllers\VariableListController::class, 'updateVariable']);
 
// for Product list page  in office 
Route::get('/Product-List', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'productforcreatepage'])->name('product.index');


Route::post('/save-product', [App\Http\Controllers\ProductController::class, 'saveProduct']);
//Variable-List page  to show all variable
Route::get('/Variable-List', [ App\Http\Controllers\VariableListController::class, 'index'])->name('variable.index');
Route::post('/save-variable', [App\Http\Controllers\VariableListController::class, 'saveVariable']);
//Route::post('/save-variable', [App\Http\Controllers\VariableListController::class, 'saveProduct']);
Route::get('/fetch-variables', [App\Http\Controllers\VariableListController::class, 'fetchVariables']);

//to pass variables to createcontract.blade.php
Route::get('/createcontract', [App\Http\Controllers\createcontractController::class, 'show'])->name('createcontract.show');
Route::get('/createvariablecontract', [App\Http\Controllers\ContractController::class, 'show']);
Route::get('/products', [App\Http\Controllers\createcontractController::class, 'productforcreatepage'])->name('createcontract.productforcreatepage');

// web.php
//Route::get('/createcontract', function () { return view('createcontract');})->name('createcontract');
//Route::match(['get', 'post'], '/createcontract', [App\Http\Controllers\ContractController::class, 'create'])->name('createcontract');

//Route::get('/createcontract', [App\Http\Controllers\createcontractController::class, 'index'])->name('createcontract.index');
 
Route::post('/createcontract', [App\Http\Controllers\CreateContractController::class, 'store'])->name('createcontract.store');
 
Route::post('/savecontract', [App\Http\Controllers\ContractController::class, 'savecontract']);

// edit purposes 

// View Contract History
Route::get('/contracts/{id}/history', [App\Http\Controllers\ContractController::class, 'history'])->name('contracts.history');

// Delete Contract
Route::delete('/contracts/{id}', [App\Http\Controllers\ContractController::class, 'destroy'])->name('contracts.destroy');

 
 
Route::post('/save', [App\Http\Controllers\createcontractController::class, 'save']);

Route::post('/updatecontract', [App\Http\Controllers\ContractController::class, 'updatecontract']);
 

 

Route::get('list',[App\Http\Controllers\MemberController::class,'show']);

//Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'showProjects'])->name('projects.index');

// for edit

Route::post('/update-project/{id}', [App\Http\Controllers\ProjectController::class, 'updateProject']);

// for delete
Route::get('/delete/{id}', 'App\Http\Controllers\ProjectController@deleteProject');
//Route::get('delete/(id)',ProjectController@deleteProject');
 

// to make work
Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
 
