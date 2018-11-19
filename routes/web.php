<?php

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
})->middleware(['auth.shop'])->name('home');

Route::get('/collections', function () {
    $collection = new App\Http\Controllers\CollectionController();
    return $collection->index();
})->middleware(['auth.shop'])->name('collections');

Route::get('/products', function () {
    $product = new App\Http\Controllers\ProductController();
    return $product->sync();
})->middleware(['auth.shop'])->name('products');

