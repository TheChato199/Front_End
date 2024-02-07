<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

/*$router->get('/', function () use ($router) {
    //return $router->app->version();
    return view('login',['nombre' => 'Hola']);
});*/

$router -> get('/','login_controlador@verLogin');
$router -> post('/login','login_controlador@Login');
$router -> get('/logout','login_controlador@cerrar_session');

$router -> get('/principal','noticia_controlador@principal');
$router -> get('/admin/noticias','noticia_controlador@noticia');
$router -> get('/admin/noticias/nuevo','noticia_controlador@view_guardar');
$router -> post('/admin/noticias/save','noticia_controlador@guardar');
$router -> get('/admin/noticias/modificar/{external}','noticia_controlador@view_editar');
$router -> post('/admin/noticias/update','noticia_controlador@modificar');