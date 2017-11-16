<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/home','FilmesController:listarFilmes')->add($auth);

$app->map(['POST', 'GET'], '/', 'UserController:logar');

$app->map( ['POST', 'GET'],  '/editar/{id}', 'FilmesController:editarFilme')->add($auth);

$app->get('/sair', 'UserController:sair')->add($auth);

$app->map(['POST', 'GET'], '/add', 'UserController:novoUser')->add($auth);

$app->get('/usuarios', 'UserController:listarUsuarios')->add($auth);

$app->map(['POST', 'GET'],'/addfilme', 'FilmesController:novoFilme')->add($auth);

$app->get('/apagar/{id}', 'UserController:apagarUsuario')->add($auth);

$app->get('/excluirfilme/{id}', 'FilmesController:apagarFilme')->add($auth);