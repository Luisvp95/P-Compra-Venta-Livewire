<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Provider;
use App\Http\Livewire\Client;
use App\Http\Livewire\Busine;
use App\Http\Livewire\Printer;
use App\Http\Livewire\CategoryController;
use App\Http\Livewire\Product;
use App\Http\Livewire\Purchase;
use App\Http\Livewire\Sale;
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
//Route::resource('providers', 'Provider')->names('providers');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::group(['middleware'=> ['auth']], function(){
Route::get('/providers', Provider::class)->name('providers');
Route::get('/clients', Client::class)->name('clients');
Route::get('/categories', CategoryController::class)->name('categories');
Route::get('/products', Product::class)->name('products');
Route::get('/printers', Printer::class)->name('printers');
Route::get('/purchases', Purchase::class)->name('purchases');
Route::get('/sales', Sale::class)->name('sales');
Route::get('/busines', Busine::class)->name('busines');

   // Route::get('/providers', \App\Http\Livewire\Provider::class)->name('providers');
});