<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};
$container['db'] = function ($c){
  $settings = $c->get('settings')['db'];
  $capsule = new \Illuminate\Database\Capsule\Manager;
  $capsule->addConnection($settings);
  $capsule->setAsGlobal();
  $capsule->bootEloquent();

  return $capsule;
};
$container['upload_directory'] = __DIR__ . '/imagens';

$container['UserController'] = function($container){
	return new \Locadora\Controller\UserController($container);
};
$container['FilmesController'] = function($container){
  return new \Locadora\Controller\FilmesController($container);
};

$container['view'] = function($container){

$folder = __DIR__;

$view = new \Slim\Views\Twig($folder.'/../templates/views/', ['cache' => false]);

$view->addExtension(new \Slim\Views\TwigExtension(
  $container->router,
  $container->request->getUri()
));

return $view;

};