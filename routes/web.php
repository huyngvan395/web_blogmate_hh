<?php

use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\BlogController;
use App\Http\Controllers\User\BlogDetailController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\FollowController;
use App\Http\Controllers\User\HeartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\InfoUserController;
use App\Http\Controllers\User\ManageBlogController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\User\StatisticalController;
use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;

Route::view('/', 'initial');

Route::middleware(AdminMiddleware::class)->group(function() {
    Route::get("admin/dashboard", [DashboardController::class, 'show'])->name("admin");
    Route::get("admin/user", [UserController::class, 'show'])->name("admin.user");
    Route::get("admin/user/create_user", [UserController::class, 'showCreatePage'])->name("admin.user.create_page");
    Route::get("admin/user/store", [UserController::class, 'store']);
    Route::post("user/delete", [UserController::class, 'delete'])->name("admin.user.delete");
    Route::post("user/create", [UserController::class, 'create'])->name("admin.user.create");
    Route::get("admin/project", [ProjectController::class, 'show'])->name("admin.project");
    Route::get("admin/blog", [AdminBlogController::class, 'show'])->name('admin.blog');
    Route::get("admin/category", [CategoryController::class, 'show'])->name('admin.category');
    Route::get("admin/category/create", [CategoryController::class, 'showCreatePage'])->name('admin.category.create_page');
    Route::post("category/create", [CategoryController::class, 'create'])->name("admin.category.create");
    Route::post("category/delete", [CategoryController::class, 'delete'])->name("admin.category.delete");
    Route::post("blog/delete",[AdminBlogController::class, 'delete'])->name("admin.blog.delete");
    Route::get("admin/blog/report",[ReportController::class], 'showBlogReport')->name('admin.blog.report');
    Route::get("admin/comment/report",[ReportController::class], 'showCommentReport')->name('admin.comment.report');
});


Route::middleware('auth')->group(function () {
    Route::get('home', [HomeController::class, 'show'])->name('home');
    Route::view("about_us", "user.about_us")->name("about_us");
    Route::view("project", "user.project")->name("project");
    Route::view("volunteer", "user.volunteer")->name("volunteer");
    Route::view("contact", "user.contact")->name("contact");
    Route::get('@{infoUser}', [InfoUserController::class, 'show'])->name('user.info');
    Route::get('@{infoUser}/followers', [InfoUserController::class, 'showFollower'])->name('user.info.follower');
    Route::get('@{infoUser}/following', [InfoUserController::class, 'showFollowing'])->name('user.info.following');
    Route::get('blog', [BlogController::class, 'index'])->name('blog');
    Route::get('blog/following', [BlogController::class, 'showBlogFollow'])->name('blog.following');
    Route::get('blog/blog-detail/{id}', [BlogDetailController::class, 'show'])->name('blog.blog-detail');
    Route::get('blog/create', [ManageBlogController::class, 'create'])->name('blog.create');
    Route::post("blog/store", [ManageBlogController::class, 'store'])->name('blog.store');
    Route::post('blog/upload', [ManageBlogController::class, 'upload'])->name('blog.upload');
    Route::post("blog/destroy",[ManageBlogController::class, 'destroy']);
    Route::post('/heartBlog', [HeartController::class, 'heartBlog'])->name('heart');
    Route::post('/heartComment', [HeartController::class, 'heartComment']);
    Route::post('/fetchComment',[BlogDetailController::class, 'fetchComments']);
    Route::post('/fetchReplies',[BlogDetailController::class, 'fetchReplies']);
    Route::post('/comment', [CommentController::class, 'comment'])->name('comment');
    Route::post('/reply', [CommentController::class, 'reply'])->name('reply');
    Route::post('/follow', [FollowController::class, 'follow'])->name('follow');
    Route::post('/chat', [ChatController::class, 'index'])->name('chat');
    Route::view('me/account', 'user.profile')->name('profile');
    Route::post('logout',[Logout::class, '__invoke'])->name('logout');
    Route::get('me/statistical', [StatisticalController::class, 'index'])->name('statistical');
    Route::get('/notifications',[NotificationController::class,'index']);
    Route::post('/search',[SearchController::class, 'search']);
    Route::get('/search-page',[SearchController::class, 'show'])->name('search-page');
    Route::get('/search-page/user',[SearchController::class, 'showUser'])->name('search-page.user');
    Route::get('/search-page/blog',[SearchController::class, 'showBlog'])->name('search-page.blog');
});


require __DIR__ . '/auth.php';

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
