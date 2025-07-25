<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

	public function country(){
		return $this->belongsTo(Country::class,'country_id','id');
	}

	public function cities(){
		return $this->hasMany(City::class);
	}

}
