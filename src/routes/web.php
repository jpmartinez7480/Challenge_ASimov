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

/*header('Access-Control-Allow-Origin:  *');
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Max-Age: 3600");
*/


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router){
    $router->get('appointments', ['uses' => 'AppointmentController@index']);
    $router->get('appointment/{id}',['uses' => 'AppointmentController@show']);
    $router->get('appointment_turn/{id}',['uses' => 'AppointmentController@searchById']);
    $router->get('turns/{day}', ['uses' => 'AppointmentController@searchTurnsAvailables']);
    $router->post('appointment',['uses'=>'AppointmentController@create']);
    $router->put('appointment/{id}',['uses' => 'AppointmentController@update']);
    $router->delete('appointment/{id}',['uses' => 'AppointmentController@delete']);
});
