<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

	protected $table = "countries";

	protected $casts = [
		'timezones' => 'array',
		'translations' => 'array'
	];

	public function states(){
		return $this->hasMany(State::class);
	}

	public function cities(){
		return $this->hasMany(City::class);
	}

}
