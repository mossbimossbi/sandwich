<?php
require __DIR__ . '/../src/vendor/autoload.php';
require __DIR__ . '/../src/control/control.php';
require __DIR__ . '/../src/models/Sandwich.php';
require __DIR__ . '/../src/models/Categorie.php';
require __DIR__ . '/../src/models/Commande.php';
require __DIR__ . '/../src/models/Taille.php';

use Firebase\JWT\JWT;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Ramsey\Uuid\Uuid;
use Respect\Validation\Validator as v;

$config = parse_ini_file('../src/conf/lbs.db.conf.ini');

$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection( $config );
$db->setAsGlobal();
$db->bootEloquent();

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

$validators = [
 'nom_client'=>v::StringType()->alpha()->notEmpty(),
 'mail_client'=>v::email()->notEmpty(),
 'date'=>v::date('Y-m-d')->min('now')->notEmpty(),
];

require __DIR__ . '/../src/container/container.php';

require __DIR__ . '/../src/route/routes.php';

$app->run();

////======================================================================
//// Registrar una categoria
////======================================================================
//
//$app->post('/categorie[/]',
//	function (Request $request, Response $response, $args){
//
//      $data = $request->getParsedBody();
//      //var_dump($data);
//
//
//      if (!isset($data['nom'])) return $response->withStatus(400);
//      if (!isset($data['description'])) return $response->withStatus(400);
//
//      $myCategorie = new lbs\models\Categorie();
//      $myCategorie->nom = filter_var($data['nom'], FILTER_SANITIZE_SPECIAL_CHARS);
//      $myCategorie->description = filter_var($data['description'], FILTER_SANITIZE_SPECIAL_CHARS);
//      $myCategorie->save();
//
//      return $response->withStatus(201);
//
//    });
//
////VALIDATOR

//
//    //======================================================================
//    // Registrar un commande
//    //======================================================================
//    $app->post('/commande[/]',
//    	function (Request $request, Response $response, $args){
//            if($request->getAttribute('has_errors')){
//               $errors = $request->getAttribute('errors');
//               $response = $response->withStatus(400)->withHeader('Content-Type', 'application/json');
//              $response->getBody()->write(json_encode($errors ));
//              return $response;
//            }else{
//
//        $data = $request->getParsedBody();
//
//        if (!isset($data['nom_client'])) return $response->withStatus(400);
//        if (!isset($data['mail_client'])) return $response->withStatus(400);
//        if (!isset($data['date'])) return $response->withStatus(400);
//        if (!isset($data['heure'])) return $response->withStatus(400);
//
//        $myCommande = new lbs\models\Commande();
//        $myCommande->id = Uuid::uuid4();
//        $myCommande->nom_client = filter_var($data['nom_client'], FILTER_SANITIZE_SPECIAL_CHARS);
//        $myCommande->mail_client = filter_var($data['mail_client'], FILTER_SANITIZE_SPECIAL_CHARS);
//        $myCommande->date = filter_var($data['date'], FILTER_SANITIZE_SPECIAL_CHARS);
//        $myCommande->heure = filter_var($data['heure'], FILTER_SANITIZE_SPECIAL_CHARS);
//        $myCommande->token = bin2hex(openssl_random_pseudo_bytes(32));
//        $myCommande->save();
//
//        $savedCommande = [
//          "commande" => [
//            "nom_client" => $myCommande->nom_client,
//            "mail_client" => $myCommande->mail_client,
//            "livraison" => [
//              "date" => $myCommande->date,
//              "heure" => $myCommande->heure,
//            ],
//          ],
//          "id" => $myCommande->id,
//          "token" => $myCommande->token,
//        ];
//
//        $response = $response->withStatus(201)->withHeader('Content-Type', 'application/json');
//  			$response->getBody()->write(json_encode($savedCommande));
//  			return $response;
//        }
//      })->add(new sv($validators));
//
//      //======================================================================
//      // Recuperar une commande
//      //======================================================================
//
//      $app->get('/commandes/{id}',
//      	function(Request $req, Response $resp, $args) {
//      	$id = $args['id'];
//
//          try {
//        		$myCommande = lbs\models\Commande::findOrFail($id);
//            $foundCommande = [
//              "commande" => [
//                "nom_client" => $myCommande->nom_client,
//                "mail_client" => $myCommande->mail_client,
//                "livraison" => [
//                  "date" => $myCommande->date,
//                  "heure" => $myCommande->heure,
//                ],
//              ],
//              "id" => $myCommande->id,
//              "token" => $myCommande->token,
//            ];
//      	  	$resp = $resp->withHeader('Content-Type', 'application/json');
//        		$resp->getBody()->write(json_encode($foundCommande));
//        		return $resp;
//          } catch ( Illuminate\Database\Eloquent\ModelNotFoundException $e ) {
//      			$resp = $resp->withStatus(404)->withHeader('Content-Type', 'application/json');
//      			$resp->getBody()->write(json_encode('CHALE, NO TENEMOS ESA COMANDA'));
//      			return $resp;
//          }
//      })->add(function(Request $req, Response $resp, callable $next) {
//
//          //Récupérer l'identifiant de cmmde dans la route et le token
//          $id = $req->getAttribute('route')->getArgument('id');
//          $token = $req->getQueryParam('token', null);
//
//          // vérifier que le token correspond à la command
//          try{
//            lbs\models\Commande::where('id', '=', $id)
//            ->where('token', '=',$token)
//            ->firstOrFail();
//          }
//          catch(ModelNotFoundException $e){
//            // générer une erreur
//            return $resp;
//          };
//          return $next ($req, $resp);
//        });
//
//

//
////======================================================================
////PROBANDO EL FIREBASE
////======================================================================
//
//$app->get('/fire[/]',
//	function(Request $req, Response $resp, $args) {
//    $token = JWT::encode(['iss' => 'http://auth.myapp.net',
//                          'aud' => 'http://api.myapp.net',
//                          'iat' => time(), 'exp' => time() + 3600,
//                          'uid' => 'usuario_anonimo',
//                          'lvl' => 'nivel_dios' ],
//                          $secretKey, 'HS512');
//
//                          $resp = $resp->withHeader('Content-Type', 'application/json');
//                          $resp->getBody()->write(json_encode($token));
//                          return $resp;
//
//});
//
//$app->run();
