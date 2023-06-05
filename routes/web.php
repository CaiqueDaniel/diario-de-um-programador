<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\{
    Auth,
    Route
};

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

Auth::routes();

Route::get('', [HomeController::class, 'index']);

Route::view('artigo', 'pages.app.post.post');

Route::middleware('auth')->prefix('painel')->group(function () {
    Route::prefix('artigos')->group(function () {
        Route::view('criar', 'pages.admin.post.form')->name('admin.post.create');

        Route::controller(PostController::class)->group(function () {
            Route::get('listar', 'index')->name('admin.post.index')->withTrashed();
            Route::get('editar/{post}', 'edit')->name('admin.post.edit')->withTrashed();

            Route::post('', 'store')->name('admin.post.store');
            Route::put('{post}', 'update')->name('admin.post.update')->withTrashed();

            Route::patch('{post}/desativar', 'trash')->name('admin.post.trash')->withTrashed();
            Route::patch('{post}/ativar', 'restore')->name('admin.post.restore')->withTrashed();

            Route::delete('{post}', 'destroy')->name('admin.post.destroy')->withTrashed();
        });
    });

    Route::prefix('categorias')->group(function () {
        Route::view('criar', 'pages.admin.category.form')->name('admin.category.create');

        Route::controller(CategoryController::class)->group(function () {
            Route::get('listar', 'index')->name('admin.category.index');

            Route::post('', 'store')->name('admin.category.store');
        });
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
