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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/keygen', function () {
    return \Illuminate\Support\Str::random(32);
});

$router->post('/ota/register', 'UserController@registerOTA');
$router->post('/sekolah/register', 'UserController@registerSekolah');

$router->group(['middleware' => 'client'], function () use ($router) {
    $router->get('/get', function () {
        return \Illuminate\Support\Facades\Auth::user();
    });

    $router->post('/post', function () {
        return 'hello post';
    });

    $router->get('/profile', 'UserController@getProfile');


    $router->get('/ota/', 'OrangTuaAsuhController@getHistory');
    $router->post('/ota/order', 'OrangTuaAsuhController@order');
    $router->post('/ota/bayar/{order_id}', 'OrangTuaAsuhController@confirmPayment');

    $router->post('/sekolah/pengajuan/anakasuh', 'SekolahController@pengajuanAA');
});

