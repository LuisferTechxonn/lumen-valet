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

$router->get('/api', function () use ($router) {
    return $router->app->version();
});

$router->get('/api/user/{user_id}', 'UserController@getUserData');

//$router->put('/api/user/{user_id}', 'UserController@update');

$router->get('/api/user', 'UserController@getUserList');


/**
 * Rutas de Books
 */
$router->get('/api/books','BooksController@getBooksAll');


$router->get('/api/books/{book_id}','BooksController@getBookById');
$router->post('/api/books','BooksController@postBook');
$router->put('/api/books/{book_id}','BooksController@putBook');
$router->patch('/api/books/{book_id}','BooksController@patchBook');
$router->delete('/api/books/{book_id}','BooksController@deleteBook');


/**
 * Rutas de Cars, que la hacemos con Swagger
 */
