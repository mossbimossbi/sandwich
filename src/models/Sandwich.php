<?php
namespace api\Models;

class Sandwich extends \Illuminate\Database\Eloquent\Model {

  protected $table      = 'sandwich';
  protected $primaryKey = 'id';
  public    $timestamps = false;

	public function categories() {
		return $this->hasMany('api\Models\Categorie',
								'sand2cat',
								'sand_id',
								'cat_id');
	}

  public function tailles(){
    return $this->belongsToMany( 'api\Models\Taille',
                                  'tarif',
                                  'sand_id',
                                  'taille_id')
                      ->withPivot("prix");
  }
  
  public function commandes() {
    return $this->belongsToMany( 'Api\Models\Commande',
                                  'sand_comm',
                                  'id_sand',
                                  'id_commande')
                      ->withPivot("id_taille");
	}
}
