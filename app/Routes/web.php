<?php

use App\Controllers\Front\AccountController as FrontAccountController;
use App\Controllers\Back\AccountController as BackAccountController;
use App\Controllers\UtilsController;
use App\Controllers\Back\MenuController as BackMenuController;
use App\Controllers\Front\MenuController as FrontMenuController;
use App\Controllers\MainController;
use App\Controllers\AuthController;
use App\Controllers\Back\StatController as BackStatController;
use App\Controllers\UserController;
use App\Controllers\PostController;
use App\Controllers\PageController;
use App\Controllers\Front\ForgotPasswordController;
use App\Controllers\Front\MessageController as FrontMessageController;
use App\Controllers\Back\MessageController as BackMessageController;
use App\Controllers\Front\MovieController AS FrontMovieController;
use App\Controllers\Back\MovieController AS BackMovieController;
use App\Controllers\Back\CategoryMovieController AS BackCategoryMovieController;
use App\Controllers\Back\ProductorController AS BackProductorController;
use App\Controllers\Front\CommentController as FrontCommentController;
use App\Controllers\Back\CommentController as BackCommentController;
use App\Controllers\Back\CommentReplyController as BackCommentReplyController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\RoleMiddleware;
use App\Models\ForgotPassword;

$router = \App\Core\Router::getInstance();

/**
 * GET
 */

$router->get('/', MainController::class, 'home');

$router->get('/account/profile', FrontAccountController::class, 'show')->middleware(AuthMiddleware::class);
$router->get('/account/setting', FrontAccountController::class, 'edit')->middleware(AuthMiddleware::class);


$router->get('/verify-account', FrontAccountController::class, 'verifyAccount')->middleware(AuthMiddleware::class);
$router->get('/resend-activation', FrontAccountController::class, 'resendMail')->middleware(AuthMiddleware::class);
$router->get('/activate-account/{token}', FrontAccountController::class, 'activateAccount');

$router->get('/login', AuthController::class, 'login');
$router->get('/logout', AuthController::class, 'logout')->middleware(AuthMiddleware::class);
$router->get('/register', AuthController::class, 'register');

$router->get( '/forgot-password', ForgotPasswordController::class, 'index');
$router->get( '/forgot-password/{token}', ForgotPasswordController::class, 'edit');

$router->get('/message', FrontMessageController::class, 'create');

$router->get('/admin/dashboard', BackStatController::class, 'dashboard')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/utils/list', UtilsController::class, 'list')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/utils/generate-sitemap', UtilsController::class, 'generateSitemap')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->get('/admin/user/list', UserController::class, 'list')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/user/create', UserController::class, 'create')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/user/show/{id}', UserController::class, 'show')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/user/edit/{id}', UserController::class, 'edit')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->get('/admin/post/list', PostController::class, 'list')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/post/create', PostController::class, 'create')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/post/show/{id}', PostController::class, 'show')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/post/edit/{id}', PostController::class, 'edit')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->get('/admin/comment/list', BackCommentController::class, 'list')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/comment/show/{id}', BackCommentController::class, 'show')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/comment/edit/{id}', BackCommentController::class, 'edit')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->get('/admin/comment-reply/list', BackCommentReplyController::class, 'list')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/comment-reply/show/{id}', BackCommentReplyController::class, 'show')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/comment-reply/edit/{id}', BackCommentReplyController::class, 'edit')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->get('/admin/message/list', BackMessageController::class, 'list')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/message/create', BackMessageController::class, 'create')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/message/show/{id}', BackMessageController::class, 'show')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/message/edit/{id}', BackMessageController::class, 'edit')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->get('/admin/page/list', PageController::class, 'list')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/page/create', PageController::class, 'create')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/page/show/{id}', PageController::class, 'show')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/page/edit/{id}', PageController::class, 'edit')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->get('/admin/movie/list', BackMovieController::class, 'list')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/movie/create', BackMovieController::class, 'create')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/movie/edit/{id}', BackMovieController::class, 'edit')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/movie/show/{id}', BackMovieController::class, 'show')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->get('/movie/show/{id}', FrontMovieController::class, 'show');

$router->get('/admin/category-movie/list', BackCategoryMovieController::class, 'list')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/category-movie/create', BackCategoryMovieController::class, 'create')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/category-movie/edit/{id}', BackCategoryMovieController::class, 'edit')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/category-movie/show/{id}', BackCategoryMovieController::class, 'show')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->get('/admin/productor/list', BackProductorController::class, 'list')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/productor/create', BackProductorController::class, 'create')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/productor/edit/{id}', BackProductorController::class, 'edit')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/productor/show/{id}', BackProductorController::class, 'show')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);


$router->get('/admin/menu/list', BackMenuController::class, 'list')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/menu/create', BackMenuController::class, 'create')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/menu/show/{id}', BackMenuController::class, 'show')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/menu/edit/{id}', BackMenuController::class, 'edit')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);


/**
 * POST
 */

$router->post('/login', AuthController::class, 'loginProcess');
$router->post('/register', AuthController::class, 'registerProcess');
$router->post('/forgot-password/store/', ForgotPasswordController::class, 'store');
$router->post('/forgot-password/update/{token}', ForgotPasswordController::class, 'update');

$router->post('/message/home/store', FrontMessageController::class, 'store');

$router->post('/admin/post/store', PostController::class, 'store')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->post('/admin/post/update/{id}', PostController::class, 'update')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->post('/admin/message/store', BackMessageController::class, 'store')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->post('/admin/message/update/{id}', BackMessageController::class, 'update')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->post('/admin/page/store', PageController::class, 'store')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->post('/admin/page/update/{id}', PageController::class, 'update')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->post('/admin/movie/store', BackMovieController::class, 'store')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->post('/admin/movie/update/{id}', BackMovieController::class, 'update')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->post('/admin/category-movie/store', BackCategoryMovieController::class, 'store')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->post('/admin/category-movie/update/{id}', BackCategoryMovieController::class, 'update')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->post('/account/account/update', FrontAccountController::class, 'update')->middleware(AuthMiddleware::class);

$router->post('/admin/productor/store', BackProductorController::class, 'store')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->post('/admin/productor/update/{id}', BackProductorController::class, 'update')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

$router->post('/comment/store', FrontCommentController::class, 'storeComment')->middleware(AuthMiddleware::class);
$router->post('/comment/reply/store', FrontCommentController::class, 'storeReply')->middleware(AuthMiddleware::class);

$router->post('/admin/comment/update/{id}', BackCommentController::class, 'update')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->post('/admin/comment-reply/update/{id}', BackCommentReplyController::class, 'update')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);


$router->post('/admin/user/store', UserController::class, 'store')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->post('/admin/user/update/{id}', UserController::class, 'update')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);


$router->post('/admin/menu/store', BackMenuController::class, 'store')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->post('/admin/menu/update/{id}', BackMenuController::class, 'update')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);

/**
 * DELETE
 */

// $router->delete('/admin/post/delete/{id}', PostController::class, 'delete')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
// TODO Lotfi : Pour l'instant en get pour avancer

$router->get('/admin/post/delete/{id}', PostController::class, 'delete')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/user/delete/{id}', UserController::class, 'delete')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/message/delete/{id}', BackMessageController::class, 'delete')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/page/delete/{id}', PageController::class, 'delete')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/movie/delete/{id}', BackMovieController::class, 'delete')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/category-movie/delete/{id}', BackCategoryMovieController::class, 'delete')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/productor/delete/{id}', BackProductorController::class, 'delete')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/comment/delete/{id}', BackCommentController::class, 'delete')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/comment-reply/delete/{id}', BackCommentReplyController::class, 'delete')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
$router->get('/admin/menu/delete/{id}', BackMenuController::class, 'delete')->middleware(AuthMiddleware::class)->middleware(RoleMiddleware::class, ['admin']);
