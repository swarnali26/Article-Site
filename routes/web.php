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
$router->post("create","Usercontroller@create");
$router->post("login","Authcontroller@login");
 //$router->post("upload","Usercontroller@uploadImage");

$router->group(['middleware' => 'auth'], function ($router) {
$router->post("createarticles","ArticleController@createArticle");
$router->get("showarticles","ArticleController@showArticle");
$router->post("comment","CommentController@comment");
$router->post("follow","Usercontroller@follow");
$router->post("unfollow","Usercontroller@unfollow");
$router->put('/update/{id}',"ArticleController@update");
$router->get("Adminview","AdminController@adminview");
$router->delete("AdminDeleteArticle","AdminController@adminDeleteArticle");
$router->delete("logout","Usercontroller@logout");
});


