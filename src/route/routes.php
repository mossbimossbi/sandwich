<?php
use \DavidePastore\Slim\Validation\Validation as sv;

$app->get('/hello/{name}', api\Control\Control::class . ':test');
/*************************SANDWICH*****************************************/

$app->get('/sandwich/{id}', api\Control\Control::class . ':getSandwich');
$app->get('/sandwiches[/]', api\Control\Control::class . ':getAllSandwich');
$app->get('/sandwichesPag[/]', api\Control\Control::class . ':getAllSandwichPag');
$app->get('/sandPain/{type}', api\Control\Control::class . ':getSandwichPain');
//$app->post('/sandwiches[/]', api\Control\Control::class . 'setSandwich');

/*************************SANDWICH-CATEGORIE******************************/

$app->get('/catSandwich/{id}', api\Control\Control::class . ':getCatSand');
$app->get('/sandCategorie/{id}', api\Control\Control::class . ':getSandCat');

/*************************CATEGORIE***************************************/

$app->get('/categories[/]', api\Control\Control::class . ':getCategories');
$app->get('/categorie/{id}', api\Control\Control::class . ':getCategorie');
$app->post('/setCategorie[/]', api\Control\Control::class . ':setCategorie');

/******************************COMMANDE*************************************/

$app->post('/commande[/]', api\Control\Control::class . ':setCommande')->add(new sv($validators));
