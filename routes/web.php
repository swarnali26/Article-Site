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

$router->group(['middleware' => 'auth'], function ($router) {
$router->get("createarticles","Usercontroller@createArticle");
});
$router->group(['middleware' => 'auth'], function ($router) {
$router->get("showarticles","Usercontroller@showArticle");
});
$router->group(['middleware' => 'auth'], function ($router) {
    $router->get("comment","Usercontroller@comment");
    });
$router->group(['middleware' => 'auth'], function ($router) {
$router->get("follow","Usercontroller@follow");
});
$router->group(['middleware' => 'auth'], function ($router) {
$router->get("unfollow","Usercontroller@unfollow");
});
$router->group(['middleware' => 'auth'], function ($router) {
    $router->put('/update/{id}',"usercontroller@update");
});
$router->group(['middleware' => 'auth'], function ($router) {
$router->get("Adminview","Usercontroller@adminview");
});
$router->group(['middleware' => 'auth'], function ($router) {
$router->get("AdminDeleteArticle","Usercontroller@adminDeleteArticle");
});
$router->group(['middleware' => 'auth'], function ($router) {
$router->delete("logout","Usercontroller@logout");
});

