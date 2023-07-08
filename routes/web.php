<?php

use App\Http\Controllers\Admin\{
    HomeController as AdminHomeController,
    CategoryController as AdminCategoryController,
    FullBannerController,
    PostController as AdminPostController,
};

use App\Http\Controllers\Web\{
    HomeController as WebHomeController,
    PostController as WebPostController,
    CategoryController as WebCategoryController,
};

use Illuminate\Support\Facades\{Auth, Route};

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

Route::get('', [WebHomeController::class, 'index'])->name('web.home');
Route::get('artigo/{slug}', [WebPostController::class, 'show'])->name('web.post.view');
Route::get('categoria/{category:permalink}', [WebCategoryController::class, 'show'])->name('web.category.view');

Route::middleware('auth')->prefix('painel')->group(function () {
    Route::get('', [AdminHomeController::class, 'index'])->name('admin.home');

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

        Route::controller(AdminCategoryController::class)->group(function () {
            Route::get('listar', 'index')->name('admin.category.index');
            Route::get('editar/{category}', 'edit')->name('admin.category.edit')->withTrashed();

            Route::post('', 'store')->name('admin.category.store');
            Route::put('{category}', 'update')->name('admin.category.update')->withTrashed();

            Route::patch('{category}/desativar', 'trash')->name('admin.category.trash')->withTrashed();
            Route::patch('{category}/ativar', 'restore')->name('admin.category.restore')->withTrashed();

            Route::delete('{category}', 'destroy')->name('admin.category.destroy')->withTrashed();
        });
    });

    Route::prefix('fullbanners')->group(function () {
        Route::view('criar', 'pages.admin.fullbanner.form')->name('admin.fullbanner.create');

        Route::controller(FullBannerController::class)->group(function () {
            Route::get('listar', 'index')->name('admin.fullbanner.index')->withTrashed();
            Route::get('editar/{fullbanner}', 'edit')->name('admin.fullbanner.edit')->withTrashed();

            Route::post('', 'store')->name('admin.fullbanner.store');
            Route::put('{fullbanner}', 'update')->name('admin.fullbanner.update')->withTrashed();

            Route::patch('{fullbanner}/desativar', 'trash')->name('admin.fullbanner.trash')->withTrashed();
            Route::patch('{fullbanner}/ativar', 'restore')->name('admin.fullbanner.restore')->withTrashed();

            Route::delete('{fullbanner}', 'destroy')->name('admin.fullbanner.destroy')->withTrashed();
        });
    });
});
