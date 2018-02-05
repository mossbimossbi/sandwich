<?php
namespace api\models;

class Taille extends \Illuminate\Database\Eloquent\Model {

  protected $table = 'taille_sandwich';
  protected $primaryKey = 'id';
  public $timestamps = false;

  public function sandwichs(){
    return $this->belongsToMany( 'catawich\models\Sandwich',
                               'tarif',
                               'taille_id',
                               'sand_id')
               ->withPivot("prix");
 }

 public function commandes() {
   return $this->belongsToMany( 'Api\Models\Commande',
                                 'sand_comm',
                                 'id_taille',
                                 'id_commande')
                     ->withPivot("id_sand");
 }

}
