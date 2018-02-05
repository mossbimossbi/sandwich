<?php
$container = $app->getContainer();

$container['view'] = function ($container) {
    $dir = dirname(__DIR__);
    $view = new \Slim\Views\Twig($dir . '/src/view', [
        'cache' => false //$dir . '/tmp/cache'
    ]);
  
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['notFoundHandler'] = function($c) {
	return function( $req, $resp ) {
		$resp= $resp->withStatus(400)->withHeader('Content-Type', 'application/json');
       $resp->getBody()->write( json_encode(['message'=>'Bad Request']));
       return $resp;
		// Debes hacelo en 2 pasos porque write no crea una requet, solo modifica una existente
	};
};

$container['errorHandler'] = function($c) {
	return function( $req, $resp, $e ) {
		$resp= $resp->withStatus(500)->withHeader('Content-Type', 'application/json');
       $resp->getBody()->write( json_encode([$e])); // 'message'=>'Internal Server Error'
       return $resp;
	};
};

$container['notAllowedHandler'] = function($c) {
	return function( $req, $resp, $methods ) {
		$resp= $resp->withStatus(405)->withHeader('Allow', implode(',', $methods), 'application/json');
       $resp->getBody()->write(json_encode($methods));
       return $resp;
		// Por si no lo notaste, $methods, es un array que guarda todos los metodos (GET, POST...), disponibles para esta URI
	};
};
