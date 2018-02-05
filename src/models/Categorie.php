<?php
namespace api\Models;

class Categorie extends \Illuminate\Database\Eloquent\Model {

  protected $table      = 'categorie';
  protected $primaryKey = 'id';
  public    $timestamps = false;

	public function sandwiches() {
		return $this->hasMany(	'api\Models\Sandwich',
								'sand2cat',
								'cat_id',
								'sand_id');
	}
  
}
