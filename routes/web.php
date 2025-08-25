<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/page1', [PageController::class, 'index'])->name('page1');
Route::get('/page1', [PageController::class, 'page1'])->name('page1');

// 新規作成フォーム表示
Route::get('/products/create', [PageController::class, 'create'])->name('products.create');
// 新規作成フォーム送信処理
Route::post('/products', [PageController::class, 'store'])->name('products.store');
// 詳細ページ
Route::get('/products/{id}', [PageController::class, 'show'])->name('products.show');
// 削除処理
Route::delete('/products/{id}', [PageController::class, 'destroy'])->name('products.destroy');

// 編集フォーム表示
Route::get('/products/{id}/edit', [PageController::class, 'edit'])->name('products.edit');
// 更新処理
Route::put('/products/{id}', [PageController::class, 'update'])->name('products.update');