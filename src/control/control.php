<?php
namespace api\Control;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use api\Models\Sandwich;
use api\Models\Categorie;
use api\Models\Commande;

use Ramsey\Uuid\Uuid;

class Control{

  public function test($request, $response, $args){
        return $response->write("Hello " . $args['name']);
  }
/***********************SANDWICH***************************/

public function getSandwichPain($request, $response, $args) {
  $type = $args['type'];
  try {
    $mySandwich = $mySandwich = Sandwich::select("nom", "description", "type_pain")->where('type_pain', '=', $type)->orderBy('type_pain')->get();
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($mySandwich));
    return $response;

  } catch ( ModelNotFoundException $e ) {

    $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode('Nous avons pas cette sandwich'));
    return $response;

  }
}

  public function getSandwich($request, $response, $args) {
    $id = $args['id'];
    try {

      $mySandwich = Sandwich::findOrFail($id);
      $response = $response->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode($mySandwich));
      return $response;

    } catch ( ModelNotFoundException $e ) {

      $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode('Nous avons pas cette sandwich'));
      return $response;

    }
  }

  public function getAllSandwichPag($request, $response, $args) {
    try {

      $mySandwich = Sandwich::all();
      $response = $response->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode($mySandwich));
      return $response;

    } catch ( ModelNotFoundException $e ) {

      $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode('Nous avons pas cette sandwich'));
      return $response;

    }
  }

  public function getAllSandwich($request, $response, $args) {
    try {

      $mySandwich = Sandwich::all();
      $response = $response->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode($mySandwich));
      return $response;

    } catch ( ModelNotFoundException $e ) {

      $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode('Nous avons pas cette sandwich'));
      return $response;

    }
  }



  public function setSandwich($request, $response, $args){

  }
/*****************************CATEGORIE-SANDWICH*******************/

  public function getCatSand($request, $response, $args){
    $id = $args['id'];
    try {
      $categorie = Categorie::join('sand2cat', 'categorie.id', '=', 'sand2cat.cat_id')
             ->join('sandwich', 'sand2cat.sand_id', '=', 'sandwich.id')
             ->select('categorie.*')
             ->where('sandwich.id', '=', $id)
             ->get();
      $response = $response->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode($categorie));
      return $response;
    } catch ( ModelNotFoundException $e ) {
      $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode('CHALES MAISTRO, NO TENEMOS ESA CATEGORIA'));
      return $response;
    }
  }

  public function getSandCat($request, $response, $args){
    $id = $args['id'];
    try {
      $categorie = Sandwich::join('sand2cat', 'sandwich.id', '=', 'sand2cat.sand_id')
             ->join('categorie', 'sand2cat.cat_id', '=', 'categorie.id')
             ->select('sandwich.*')
             ->where('categorie.id', '=', $id)
             ->get();
      $response = $response->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode($categorie));
      return $response;
    } catch ( ModelNotFoundException $e ) {
      $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode('CHALES MAISTRO, NO TENEMOS ESA CATEGORIA'));
      return $response;
    }
  }

/****************************CATEGORIE****************************/




  public function setCategorie($request, $response, $args){
    $data = $request->getParsedBody();

    if (!isset($data['nom'])) return $response->withStatus(400);
    if (!isset($data['description'])) return $response->withStatus(400);

    $myCategorie = new Categorie();
    $myCategorie->nom = filter_var($data['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
    $myCategorie->description = filter_var($data['description'], FILTER_SANITIZE_SPECIAL_CHARS);
    $myCategorie->save();

    return $response->withStatus(201);
  }

  public function getCategories($request, $response, $args){
      $categories = Categorie::select();
     	$resp = $resp->withHeader('Content-Type', 'application/json');
    	$resp->getBody()->write(json_encode($categories));
    	return $resp;
  }

  public function getCategorie($request, $response, $args){
    $id = $args['id'];
    try {
      $mycategorie = Categorie::findOrFail($id);
      $response = $response->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode($mycategorie));
      return $response;
    } catch ( ModelNotFoundException $e ) {
      $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode('CHALES MAISTRO, NO TENEMOS ESA CATEGORIA'));
      return $response;
    }
  }

  public function setCommande($request, $response, $args){
    if($request->getAttribute('has_errors')){
      $errors = $request->getAttribute('errors');
      $response = $response->withStatus(400)->withHeader('Content-Type', 'application/json');
      $response->getBody()->write(json_encode($errors ));
      return $response;
    }else{

      $data = $request->getParsedBody();

       if (!isset($data['nom_client'])) return $response->withStatus(400);
       if (!isset($data['mail_client'])) return $response->withStatus(400);
       if (!isset($data['date'])) return $response->withStatus(400);
       if (!isset($data['heure'])) return $response->withStatus(400);

       $myCommande = new Commande();
       $myCommande->id = Uuid::uuid4();
       $myCommande->nom_client = filter_var($data['nom_client'], FILTER_SANITIZE_SPECIAL_CHARS);
       $myCommande->mail_client = filter_var($data['mail_client'], FILTER_SANITIZE_SPECIAL_CHARS);
       $myCommande->date = filter_var($data['date'], FILTER_SANITIZE_SPECIAL_CHARS);
       $myCommande->heure = filter_var($data['heure'], FILTER_SANITIZE_SPECIAL_CHARS);
       $myCommande->token = bin2hex(openssl_random_pseudo_bytes(32));
       $myCommande->save();

           $savedCommande = [
             "commande" => [
               "nom_client" => $myCommande->nom_client,
               "mail_client" => $myCommande->mail_client,
               "livraison" => [
                 "date" => $myCommande->date,
                 "heure" => $myCommande->heure,
               ],
             ],
             "id" => $myCommande->id,
             "token" => $myCommande->token,
           ];

        $response = $response->withStatus(201)->withHeader('Content-Type', 'application/json');
     		$response->getBody()->write(json_encode($savedCommande));
     		return $response;
    }
  }
}
