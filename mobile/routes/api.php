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

$app->get('/', function () use ($app) {
    return ['API Is Ready.'];
});

$app->get('example', 'ExampleController@index');

$app->get('users', function(){
    return App\Models\User::all();
});

$app->get('user/{id}', function($id){
    return App\Models\User::find($id);
});
