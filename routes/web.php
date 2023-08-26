<?php

use App\Http\Controllers\Admin\{
    HomeController as AdminHomeController,
    CategoryController as AdminCategoryController,
    FullBannerController,
    PostController as AdminPostController,
    PublishPostController as AdminPublishPostController,
    AdminController,
    UserController as AdminUserController
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
Route::get('categoria/{category:permalink}', [WebCategoryController::class, 'show'])
    ->where('category', '.+')
    ->name('web.category.view');

Route::middleware('auth')->prefix('painel')->group(function () {
    Route::get('', [AdminHomeController::class, 'index'])->name('admin.home');

    Route::prefix('usuarios')->group(function () {
        Route::view('criar', 'pages.admin.user.form')->name('admin.user.create');

        Route::controller(AdminUserController::class)->group(function () {
            Route::get('listar', 'index')->name('admin.user.index');
        });

        Route::controller(AdminController::class)->group(function () {
            Route::get('editar/{user}', 'edit')->name('admin.user.edit');

            Route::post('', 'store')->name('admin.user.store');
            Route::put('{user}', 'update')->name('admin.user.update');
            Route::delete('{user}', 'destroy')->name('admin.user.destroy');
        });
    });

    Route::prefix('artigos')->group(function () {
        Route::view('criar', 'pages.admin.post.form')->name('admin.post.create');

        Route::controller(AdminPostController::class)->group(function () {
            Route::get('listar', 'index')->name('admin.post.index')->withTrashed();
            Route::get('editar/{post}', 'edit')->name('admin.post.edit')->withTrashed();

            Route::post('', 'store')->name('admin.post.store');
            Route::put('{post}', 'update')->name('admin.post.update')->withTrashed();

            Route::patch('{post}/desativar', 'trash')->name('admin.post.trash')->withTrashed();
            Route::patch('{post}/ativar', 'restore')->name('admin.post.restore')->withTrashed();
            Route::patch('{post}/publicar', AdminPublishPostController::class)
                ->name('admin.post.publish')
                ->withTrashed();

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
