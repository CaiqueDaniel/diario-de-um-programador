<?php

use App\Http\Controllers\Admin\{
    CategoryController,
    PostController as AdminPostController
};

use App\Http\Controllers\Web\{
    HomeController,
    PostController as WebPostController
};

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

Auth::routes(['register' => false]);

Route::get('', [HomeController::class, 'index'])->name('app.home');

Route::get('artigo/{slug}', [WebPostController::class, 'show'])->name('app.post.view');

Route::middleware('auth')->prefix('painel')->group(function () {
    Route::prefix('artigos')->group(function () {
        Route::view('criar', 'pages.admin.post.form')->name('admin.post.create');

        Route::controller(AdminPostController::class)->group(function () {
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
            Route::put('{category}', 'update')->name('admin.category.update')->withTrashed();

            Route::patch('{category}/desativar', 'trash')->name('admin.category.trash')->withTrashed();
            Route::patch('{category}/ativar', 'restore')->name('admin.category.restore')->withTrashed();

            Route::delete('{category}', 'destroy')->name('admin.category.destroy')->withTrashed();
        });
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
