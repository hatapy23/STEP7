<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

//商品一覧
Route::get('/products_list', [App\Http\Controllers\ProductController::class, 'showList'])->name('show.list');
Route::delete('/products_list/{id}', [App\Http\Controllers\ProductController::class, 'deleteList'])->name('delete.list');

//商品登録
Route::get('/products_register', [App\Http\Controllers\ProductController::class, 'showForm'])->name('show.form');
Route::post('/products_register', [App\Http\Controllers\ProductController::class, 'sendForm'])->name('send.form');

//商品詳細
Route::get('/products_detail/{id}', [App\Http\Controllers\ProductController::class, 'showDetail'])->name('show.detail');

//商品編集
Route::get('/products_editor/{id}', [App\Http\Controllers\ProductController::class, 'editList'])->name('edit.list');
Route::put('/products_editor/{id}', [App\Http\Controllers\ProductController::class, 'updateList'])->name('update.list');
