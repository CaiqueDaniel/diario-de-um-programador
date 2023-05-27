<?php

use App\Http\Controllers\Admin\PostController;
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

Route::get('/', function () {
    return view('pages.app.homepage.home');
});

Route::view('artigo', 'pages.app.post.post');

Route::middleware('auth')->prefix('painel')->group(function () {
    Route::prefix('artigos')->group(function () {
        Route::view('criar', 'pages.admin.post.form')->name('admin.post.create');

        Route::controller(PostController::class)->group(function () {
            Route::get('listar', 'index')->name('admin.post.index');
            Route::get('editar/{post}', 'edit')->name('admin.post.edit');

            Route::post('', 'store')->name('admin.post.store');
            Route::put('{post}', 'update')->name('admin.post.update');
        });
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
