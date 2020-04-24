<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post("user/create","Usercontroller@create");
$router->post("login","Authcontroller@login");
 
$router->group(['middleware' => 'auth'], function ($router) {
$router->post("user/createarticles","ArticleController@createArticle");
$router->get("user/showarticles","ArticleController@showArticle");
$router->post("user/comment","CommentController@comment");
$router->post("user/follow","Usercontroller@follow");
$router->post("user/unfollow","Usercontroller@unfollow");
$router->put('user/update/{id}',"ArticleController@update");
$router->get("Admin/Adminview","AdminController@adminview");
$router->delete("Admin/AdminDeleteArticle","AdminController@adminDeleteArticle");
$router->delete("logout","Usercontroller@logout");
});


