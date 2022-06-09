<?php
// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard.index'));
});

Breadcrumbs::for('filemanager', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('File Manager', route('filemanager.index'));
});

Breadcrumbs::for('list-contact', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Inbox', route('contact.index'));
});

// Dashboard > Profile
Breadcrumbs::for('dash-profile', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Profile', route('profile.index'));
});

// Dashboard > Website Settings
Breadcrumbs::for('web_settings', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Setelan Website', route('dashboard.setting'));
});

// =================================================================

Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Kategori', route('categories.index'));
});

Breadcrumbs::for('add_category', function (BreadcrumbTrail $trail) {
    $trail->parent('categories');
    $trail->push('Buat', route('categories.index'));
});

// Dashboard > Categories > Edit
Breadcrumbs::for('edit_category', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('categories');
    $trail->push($category->title, route('categories.edit', ['category' => $category]));
});

// =================================================================

Breadcrumbs::for('tags', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Tag', route('tags.index'));
});

Breadcrumbs::for('add_tags', function (BreadcrumbTrail $trail) {
    $trail->parent('tags');
    $trail->push('Buat', route('tags.index'));
});

Breadcrumbs::for('edit_tag', function (BreadcrumbTrail $trail, $tag) {
    $trail->parent('tags');
    $trail->push($tag->title, route('tags.edit', ['tag' => $tag]));
});

// =================================================================

Breadcrumbs::for('posts', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Postingan blog', route('posts.index'));
});

Breadcrumbs::for('deleted_posts', function (BreadcrumbTrail $trail) {
    $trail->parent('posts');
    $trail->push('Trash', route('posts.index'));
});

Breadcrumbs::for('add_posts', function (BreadcrumbTrail $trail) {
    $trail->parent('posts');
    $trail->push('Buat postingan', route('posts.index'));
});

Breadcrumbs::for('detail_post', function (BreadcrumbTrail $trail, $post) {
    $trail->parent('posts', $post);
    $trail->push($post->title, route('posts.show', ['post' => $post]));
});

Breadcrumbs::for('edit_post', function (BreadcrumbTrail $trail, $post) {
    $trail->parent('posts', $post);
    $trail->push($post->title, route('posts.edit', ['post' => $post]));
});

// =================================================================

Breadcrumbs::for('roles', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Role', route('roles.index'));
});

Breadcrumbs::for('detail_role', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('roles', $role);
    $trail->push($role->name, route('roles.show', ['role' => $role]));
});

Breadcrumbs::for('add_roles', function (BreadcrumbTrail $trail) {
    $trail->parent('roles');
    $trail->push('Buat', route('roles.create'));
});

Breadcrumbs::for('edit_role', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('roles', $role);
    $trail->push($role->name, route('roles.edit', ['role' => $role]));
});

// =================================================================

Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Pengguna', route('users.index'));
});

Breadcrumbs::for('add_users', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Buat', route('users.create'));
});

Breadcrumbs::for('edit_user', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('users', $user);
    $trail->push($user->name, route('users.edit', ['user' => $user]));
});

// =================================================================

// // Home > Blog
// Breadcrumbs::for('blog', function (BreadcrumbTrail $trail) {
//     $trail->parent('home');
//     $trail->push('Blog', route('blog'));
// });

// // Home > Blog > [Category]
// Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
//     $trail->parent('blog');
//     $trail->push($category->title, route('category', $category));
// });
