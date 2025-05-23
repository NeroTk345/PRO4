<?php

// Public routes
$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');

// Guest only routes
$router->get('/register', 'AuthController@showRegisterForm')->only('guest');
$router->post('/register', 'AuthController@register')->only('guest');
$router->get('/login', 'AuthController@showLoginForm')->only('guest');
$router->post('/sessions', 'AuthController@login')->only('guest');

// Authenticated routes
$router->get('/logout', 'AuthController@logout');
$router->get('/Account', 'AccountController@profile')->only('auth');

// Notes (admin only)
$router->get('/notes', 'NoteController@index')->only('admin');
$router->get('/note', 'NoteController@show')->only('admin');
$router->get('/note/create', 'NoteController@create')->only('admin');
$router->post('/notes', 'NoteController@store')->only('admin');
$router->get('/note/edit', 'NoteController@edit')->only('admin');
$router->patch('/note', 'NoteController@update')->only('admin');
$router->delete('/note', 'NoteController@destroy')->only('admin');

// Admin only routes
$router->get('/accounts', 'AccountController@index')->only('admin');
$router->get('/shows', 'ShowController@index')->only('admin');