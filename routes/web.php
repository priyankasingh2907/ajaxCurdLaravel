<?php

use App\Http\Controllers\AcountController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/create',[AcountController::class,'index'])->name('create');
Route::post('/fetch_states/{id}',[AcountController::class,'fetchStates'])->name('fetchStates');
Route::post('/fetch_cities/{id}',[AcountController::class,'fetchCities'])->name('fetchCities');
Route::post('/save',[AcountController::class,'save'])->name('save');
Route::get('/list',[AcountController::class,'list'])->name('list');


Route::get('/edit/{id}',[AcountController::class,'edit'])->name('edit');
Route::post('/update/{id}',[AcountController::class,'update'])->name('update');

Route::post('/delete/{id}',[AcountController::class,'delete'])->name('delete');