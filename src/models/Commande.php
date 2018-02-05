<?php
namespace api\Models;

class Commande extends \Illuminate\Database\Eloquent\Model {

  protected $table = 'commande';
  protected $primaryKey = 'id';
  public $incrementing = false;
  public $keyType = 'string';
  public $timestamps = false;

  public function carte() {
    return $this->belongsTo('api\Models\Carte','id');
	}
  
  public function sandwichs() {
    return $this->belongsToMany( 'Api\Models\Sandwich',
                                  'sand_comm',
                                  'id_commande',
                                  'id_sand')
                      ->withPivot("id_taille");
  }

  public function tailles() {
    return $this->belongsToMany( 'Api\Models\Taille',
                                  'sand_comm',
                                  'id_commande',
                                  'id_taille')
                      ->withPivot("id_sand");
  }
}
