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

// redirect to google
Route::post('/auth/google', [\App\Http\Controllers\Auth\FirebaseController::class, 'redirectToGoogle'])->name('google.login');
Route::post('/auth/github', [\App\Http\Controllers\Auth\FirebaseController::class, 'redirectToGithub'])->name('github.login');
Route::post('/auth/anonymous', [\App\Http\Controllers\Auth\FirebaseController::class, 'redirectToAnonym'])->name('anonymous.login');
// SITEMAP XML
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapXmlController::class, 'index'])->name('sitemap');
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
Route::get('/authors', [\App\Http\Controllers\BlogController::class, 'showAuthors'])->name('blog.authors');
Route::get('/authors/{author}', [\App\Http\Controllers\BlogController::class, 'showPostsByAuthor'])->name('blog.author');
// Filter blog by Month and year
Route::get('blog/{year}/{month}', [\App\Http\Controllers\BlogController::class, 'showPostsbyMonthYear'])->name('blog.monthYear');
// Tutorials
Route::get('/tutorials', [\App\Http\Controllers\BlogController::class, 'showTutorial'])->name('blog.tutorials');
Route::get('/tutorials/{slug}', [\App\Http\Controllers\BlogController::class, 'showPostsByTutorial'])->name('blog.posts.tutorials');
Route::get('/tutorials/{slug}/by-{user}', [\App\Http\Controllers\BlogController::class, 'showPostsByTutorialByAuthor'])->name('blog.posts.tutorials.author');
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
// Newsletter
Route::post('newsletter', [App\Http\Controllers\Dashboard\NewsLetterController::class, 'storeEmail'])->name('newsletter.store');

Route::group(['middleware' => 'prevent-back-history'], function () {
    Auth::routes([
        "verify" => true
    ]);
    Route::group(['middleware' => 'is-anonymous'], function () {
        // auth middleware (login)
        Route::group(['prefix' => 'dashboard', 'middleware' => ['web', 'auth', 'verified']], function () {
            // Dashboard
            Route::get('/', [\App\Http\Controllers\Dashboard\DashboardController::class, 'dashboard'])->name('dashboard.index');
            // Setting website
            Route::get('/setting', [\App\Http\Controllers\Dashboard\WebSettingController::class, 'index'])->name('dashboard.setting');
            Route::put('/update-site', [\App\Http\Controllers\Dashboard\WebSettingController::class, 'updateSite'])->name('dashboard.setting.update');
            // Profiles
            Route::get('/profiles', [App\Http\Controllers\Dashboard\ProfileController::class, 'index'])->name('profile.index');
            Route::put('/update-profile', [App\Http\Controllers\Dashboard\ProfileController::class, 'updateProfile'])->name('profile.updateInfo');
            Route::post('/update-image', [App\Http\Controllers\Dashboard\ProfileController::class, 'updateImage'])->name('profile.updateImage');
            Route::put('/change-password', [App\Http\Controllers\Dashboard\ProfileController::class, 'changePassword'])->name('profile.changePassword');
            Route::put('/update-social', [App\Http\Controllers\Dashboard\ProfileController::class, 'updateSocial'])->name('profile.updateSocial');
            // CONTACT
            Route::resource('/contact', \App\Http\Controllers\ContactController::class)->except('edit', 'show', 'update');
            Route::get('/show-replay/{id}', [\App\Http\Controllers\ContactController::class, 'showInbox'])->name('contact.showReplay');
            Route::get('/replay/{id}', [\App\Http\Controllers\ContactController::class, 'replay'])->name('contact.replay');
            // Tutorial
            Route::delete('/tutorials/destroy/{id}', [\App\Http\Controllers\Dashboard\TutorialController::class, 'destroy'])->name('tutorials.destroy');
            Route::put('/tutorials/update/{id}', [\App\Http\Controllers\Dashboard\TutorialController::class, 'update'])->name('tutorial.update');
            Route::get('/tutorials/edit/{id}', [\App\Http\Controllers\Dashboard\TutorialController::class, 'edit'])->name('tutorial.edit');
            Route::get('/tutorials/show/{id}', [\App\Http\Controllers\Dashboard\TutorialController::class, 'show'])->name('tutorials.show');
            Route::post('/tutorials/store', [\App\Http\Controllers\Dashboard\TutorialController::class, 'store'])->name('tutorials.store');
            Route::get('/tutorials/fetch', [\App\Http\Controllers\Dashboard\TutorialController::class, 'fetch'])->name('tutorials.fetch');
            Route::get('/tutorials/select', [\App\Http\Controllers\Dashboard\TutorialController::class, 'select'])->name('tutorials.select');
            Route::resource('/tutorials', \App\Http\Controllers\Dashboard\TutorialController::class)->except('show', 'store', 'edit', 'update', 'destroy');
            // Category
            Route::delete('/categories/destroy/{id}', [\App\Http\Controllers\Dashboard\CategoryController::class, 'destroy'])->name('categories.destroy');
            Route::get('/categories/show/{id}', [\App\Http\Controllers\Dashboard\CategoryController::class, 'show'])->name('categories.show');
            Route::get('/categories/edit/{id}', [\App\Http\Controllers\Dashboard\CategoryController::class, 'edit'])->name('categories.edit');
            Route::put('/categories/update/{id}', [\App\Http\Controllers\Dashboard\CategoryController::class, 'update'])->name('categories.update');
            Route::get('/categories/fetch', [\App\Http\Controllers\Dashboard\CategoryController::class, 'fetch'])->name('categories.fetch');
            Route::post('/categories/store', [\App\Http\Controllers\Dashboard\CategoryController::class, 'store'])->name('categories.store');
            Route::get('/categories/create', [\App\Http\Controllers\Dashboard\CategoryController::class, 'create'])->name('categories.create');
            Route::get('/categories/select', [\App\Http\Controllers\Dashboard\CategoryController::class, 'select'])->name('categories.select');
            Route::resource('/categories', \App\Http\Controllers\Dashboard\CategoryController::class)->except('show', 'create', 'store', 'edit', 'update', 'destroy');
            // Tag
            Route::put('/tags/update/{id}', [\App\Http\Controllers\Dashboard\TagController::class, 'update'])->name('tags.update');
            Route::get('/tags/edit/{id}', [\App\Http\Controllers\Dashboard\TagController::class, 'edit'])->name('tags.edit');
            Route::delete('/tags/destroy/{id}', [\App\Http\Controllers\Dashboard\TagController::class, 'destroy'])->name('tags.destroy');
            Route::get('/tags/fetch', [\App\Http\Controllers\Dashboard\TagController::class, 'fetch'])->name('tags.fetch');
            Route::get('/tags/add-create', [\App\Http\Controllers\Dashboard\TagController::class, 'addcreate'])->name('tags.addcreate');
            Route::get('/tags/select', [\App\Http\Controllers\Dashboard\TagController::class, 'select'])->name('tags.select');
            Route::resource('/tags', \App\Http\Controllers\Dashboard\TagController::class)->except('show','create', 'destroy', 'edit', 'update');
            // Posts
            Route::get('/posts/trash', [\App\Http\Controllers\Dashboard\PostController::class, 'listsDeletePosts'])->name('posts.delete');
            Route::post('/posts/restore/{id}', [\App\Http\Controllers\Dashboard\PostController::class, 'restore'])->name('posts.restore');
            Route::put('/posts/publish/{post}', [\App\Http\Controllers\Dashboard\PostController::class, 'publish'])->name('posts.publish');
            Route::put('/posts/draft/{post}', [\App\Http\Controllers\Dashboard\PostController::class, 'draft'])->name('posts.draft');
            Route::put('/posts/approved/{post}', [\App\Http\Controllers\Dashboard\PostController::class, 'approve'])->name('posts.approval');
            Route::resource('/posts', \App\Http\Controllers\Dashboard\PostController::class)->except('show', 'edit');
            Route::get('/posts/{slug}/edit', [\App\Http\Controllers\Dashboard\PostController::class, 'edit'])->name('posts.edit');
            Route::get('/posts/{slug}', [\App\Http\Controllers\Dashboard\PostController::class, 'show'])->name('posts.show');
            Route::post('/posts/{id}/recommend', [\App\Http\Controllers\Dashboard\PostController::class, 'recommend'])->name('posts.recommend');
            // Role
            Route::get('/roles/select', [\App\Http\Controllers\Dashboard\RoleController::class, 'select'])->name('roles.select');
            Route::resource('/roles', \App\Http\Controllers\Dashboard\RoleController::class);
            // User
            Route::get('/users-show/{id}', [\App\Http\Controllers\Dashboard\UserController::class, 'showUserModal'])->name('users.showModal');
            Route::post('/user-blokir/{id}', [\App\Http\Controllers\Dashboard\UserController::class, 'blokirUser'])->name('users.blokir');
            Route::put('/user-unblokir/{user}', [\App\Http\Controllers\Dashboard\UserController::class, 'unBlokirUser'])->name('users.unblokir');
            Route::resource('/users', \App\Http\Controllers\Dashboard\UserController::class)->except('show');
            // User Provider
            Route::post('/disable-provider/{uid}', [\App\Http\Controllers\Dashboard\UserProviderController::class, 'disableProvider'])->name('users.disableProvider');
            Route::post('/enable-provider/{uid}', [\App\Http\Controllers\Dashboard\UserProviderController::class, 'enableProvider'])->name('users.enableProvider');
            Route::delete('/delete-provider/{uid}', [\App\Http\Controllers\Dashboard\UserProviderController::class, 'deleteProvider'])->name('users.deleteProvider');
            Route::resource('/user-providers', \App\Http\Controllers\Dashboard\UserProviderController::class)->except('show', 'destroy');
            // FILE MANAGER
            Route::group(['prefix' => 'filemanager'], function () {
                Route::get('/index', [\App\Http\Controllers\Dashboard\FileManagerController::class, 'index'])->name('filemanager.index');
                \UniSharp\LaravelFilemanager\Lfm::routes();
            });
            // Notification
            Route::get('/notify', [\App\Http\Controllers\Dashboard\NotificationController::class, 'notify'])->name('notify');
            Route::get('/markasread/{id}', [\App\Http\Controllers\Dashboard\NotificationController::class, 'markAsRead'])->name('markasread');
            // Newsletter
            Route::get('/newsletter', [\App\Http\Controllers\Dashboard\NewsLetterController::class, 'index'])->name('newsletter.index');
            Route::delete('/newsletter/{newsletter}', [\App\Http\Controllers\Dashboard\NewsLetterController::class, 'destroy'])->name('newsletter.destroy');
            // Chat
            Route::get('/chat-users', [\App\Http\Controllers\Dashboard\MessageController::class, 'index'])->name('chat.index');
            Route::get('/fetch-users', [\App\Http\Controllers\Dashboard\MessageController::class, 'fetchUsers'])->name('chat.fetchUsers');
            Route::get('/search-users', [\App\Http\Controllers\Dashboard\MessageController::class, 'searchUsersChat'])->name('chat.searchUsers');
            Route::get('/load-latest-message', [\App\Http\Controllers\Dashboard\MessageController::class, 'getLoadLatestMessage'])->name('chat.getLoadLatestMessage');
            Route::post('/send', [\App\Http\Controllers\Dashboard\MessageController::class, 'postSendMessage'])->name('chat.send');
            Route::get('/fetch-old-messages', [\App\Http\Controllers\Dashboard\MessageController::class, 'getOldMessages'])->name('chat.getOldMessages');
        });
    });
});
