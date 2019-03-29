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

$router->get('/appointment/list' , 'AppointmentController@list');
$router->post('/appointment/create' , 'AppointmentController@create');
$router->get('/appointment/patient/{id}' , 'AppointmentController@listByPatient');
$router->get('/appointment/doctor/{id}' , 'AppointmentController@listByDoctor');

$router->get('/patient/list' , 'PatientController@list');
$router->get('/patient/{id}' , 'PatientController@get');

$router->get('/doctor/list' , 'DoctorController@list');
$router->get('/doctor/{id}' , 'DoctorController@get');

$router->get('test', function () {
    return 'Hello World';
});

