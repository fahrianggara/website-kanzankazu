<?php

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

// LANGUAGE
Route::get('/localization/{language}', [App\Http\Controllers\LocalizationController::class, 'switch'])
    ->name('localization.switch');
// HOME
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('homepage');
// BLOG
Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.home');
Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'blogDetail'])->name('blog.detail');
// RELATED POSTS
Route::get('/related-post', [\App\Http\Controllers\BlogController::class, 'blogDetail'])->name('blog.related');
// AUTOCOMPLETE SEARCH
Route::get('autocompleteajax', [\App\Http\Controllers\BlogController::class, 'autocompleteajax'])->name('blog.autocomplete');
// AUTHORS
Route::get('/author/{author}', [\App\Http\Controllers\BlogController::class, 'showPostsByAuthor'])->name('blog.author');
// Filter blog by Month and year
Route::get('blog/{year}/{month}', [\App\Http\Controllers\BlogController::class, 'showPostsbyMonthYear'])->name('blog.monthYear');
// CATEGORIES
Route::get('/categories', [\App\Http\Controllers\BlogController::class, 'showCategory'])->name('blog.categories');
Route::get('/category/{slug}', [
    \App\Http\Controllers\BlogController::class, 'showPostsByCategory'
])->name('blog.posts.categories');
// TAGS
Route::get('/tags', [\App\Http\Controllers\BlogController::class, 'showTags'])->name('blog.tags');
Route::get('/tag/{slug}', [
    \App\Http\Controllers\BlogController::class, 'showPostsByTag'
])->name('blog.posts.tags');
// SEARCH
Route::get('/search', [
    \App\Http\Controllers\BlogController::class, 'searchPosts'
])->name('blog.search');
// CONTACT
Route::get('showform', [\App\Http\Controllers\ContactController::class, 'create'])->name('showform');
Route::post('savecontact', [\App\Http\Controllers\ContactController::class, 'save'])->name('contact.save');

Route::get('/generate', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});

Auth::routes([
    "register" => false
]);


// auth middleware (login)
Route::group(['prefix' => 'dashboard', 'middleware' => ['web', 'auth']], function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\Dashboard\DashboardController::class, 'dashboard'])->name('dashboard.index');
    // CONTACT
    Route::resource('/contact', \App\Http\Controllers\ContactController::class)->except('edit', 'show', 'update');
    // Category
    Route::get('/categories/select', [\App\Http\Controllers\Dashboard\CategoryController::class, 'select'])->name('categories.select');
    Route::resource('/categories', \App\Http\Controllers\Dashboard\CategoryController::class)->except('show');
    // Tag
    Route::get('/tags/select', [\App\Http\Controllers\Dashboard\TagController::class, 'select'])->name('tags.select');
    Route::resource('/tags', \App\Http\Controllers\Dashboard\TagController::class)->except('show');
    // Posts
    Route::get('/posts/trash', [\App\Http\Controllers\Dashboard\PostController::class, 'listsDeletePosts'])->name('posts.delete');
    Route::post('/posts/restore/{id}', [\App\Http\Controllers\Dashboard\PostController::class, 'restore'])->name('posts.restore');
    Route::resource('/posts', \App\Http\Controllers\Dashboard\PostController::class);
    // Role
    Route::get('/roles/select', [\App\Http\Controllers\Dashboard\RoleController::class, 'select'])->name('roles.select');
    Route::resource('/roles', \App\Http\Controllers\Dashboard\RoleController::class);
    // User
    Route::resource('/users', \App\Http\Controllers\Dashboard\UserController::class)->except('show');
    // FILE MANAGER
    Route::group(['prefix' => 'filemanager'], function () {
        Route::get('/index', [\App\Http\Controllers\FileManagerController::class, 'index'])->name('filemanager.index');
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
});
