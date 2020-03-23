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
//$router->get("hello","Hellocontroller@sayHello")->middleware('Authmiddleware');
//Route::GET('/hello','Hellocontroller@sayHello')->middleware('Authmiddleware');
$router->post("create","Authcontroller@create");
$router->get("login","Authcontroller@login");
$router->get("createarticles","Usercontroller@createArticle")->middleware('Authmiddleware');;
$router->get("showarticles","Usercontroller@showArticle")->middleware('Authmiddleware');;
$router->get("follow","Usercontroller@follow")->middleware('Authmiddleware');;
$router->get("unfollow","Usercontroller@unfollow")->middleware('Authmiddleware');;
$router->get("Adminview","Usercontroller@Adminview")->middleware('Authmiddleware');;
$router->get("AdminDeleteArticle","Usercontroller@unfollow")->middleware('Authmiddleware');;