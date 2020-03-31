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
$router->get("login","Authcontroller@login");
$router->get("createarticles","Usercontroller@createArticle");
$router->get("showarticles","Usercontroller@showArticle");
$router->get("follow","Usercontroller@follow");
$router->get("unfollow","Usercontroller@unfollow");
$router->get("Adminview","Usercontroller@adminview");
$router->get("AdminDeleteArticle","Usercontroller@adminDeleteArticle");
