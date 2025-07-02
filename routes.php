<?php

//alle main routes dat zit op de pagina!
$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');

$router->get('/notes', 'notes/index.php')->only('auth');
$router->get('/note', 'notes/show.php');
$router->get('/shows', 'shows/index.php');
$router->post('/shows/create', 'shows/create.php');
$router->post('/shows/buy', 'shows/buy.php');
$router->post('/shows/delete', 'shows/delete.php');
$router->post('/shows/update', 'shows/update.php');
$router->get('/shows/buy/success', 'shows/success.php');
$router->delete('/note', 'notes/destroy.php');

$router->get('/note/edit', 'notes/edit.php');
$router->patch('/note', 'notes/update.php');

$router->get('/note/create', 'notes/create.php');
$router->post('/notes', 'notes/store.php');
$router->post('/notes/respond', 'notes/respond.php');

$router->get('/register', 'Regristration/create.php')->only('guest');
$router->post('/register', 'Regristration/store.php');

$router->get('/login', 'sessions/create.php')->only('guest');
$router->post('/sessions', 'sessions/store.php')->only('guest');
$router->get('/logout', 'sessions/logout.php');

$router->get('/Account', 'Account/AccountController.php')->only('auth');
$router->get('/admin/members', 'admin/members.php')->only('auth');
$router->post('/admin/members/create', 'admin/members_create.php')->only('auth');
$router->get('/admin/members/update', 'admin/members_update.php')->only('auth');
$router->patch('/admin/members/update', 'admin/members_update.php')->only('auth');
$router->delete('/admin/members/delete', 'admin/members_delete.php')->only('auth');
$router->get('/admin/members_update.php', 'admin/members_update.php')->only('auth');
$router->post('/admin/members_update.php', 'admin/members_update.php')->only('auth');



