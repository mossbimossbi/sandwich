<?php
namespace Api\Control;

class control{

  public function test($request, $response, $args){
        return $response->write("Hello " . $args['name']);
  }

  public function getSandwich(Request $req, Response $resp, $args) {

    $id = $args['id'];

      try {
    $mySandwich = lbs\models\Sandwich::findOrFail($id);

      $resp = $resp->withHeader('Content-Type', 'application/json');
    $resp->getBody()->write(json_encode($mySandwich));
    return $resp;
      } catch ( Illuminate\Database\Eloquent\ModelNotFoundException $e ) {
      $resp = $resp->withStatus(404)->withHeader('Content-Type', 'application/json');
      $resp->getBody()->write(json_encode('CHALES MAISTRO, NO TENEMOS ESE SANDWICH'));
      return $resp;
          
    }
  }
}