<?php
namespace api\Models;

class Carte extends \Illuminate\Database\Eloquent\Model {

  protected $table = 'carte';
  protected $primaryKey = 'id';
  public $incrementing = false;
  public $keyType = 'string';
  public $timestamps = false;

  public function commande(){
    return $this->hasMany( 'api\Models\Commande', 'id');
  }
}
