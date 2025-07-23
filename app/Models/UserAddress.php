<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\BelongsToUserScope;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAddress extends Model
{
    use HasFactory, LogsActivity, HasRevisions;

    protected $fillable = [
        'name',
        'address',
        'user_id',
        'city_id',
        'state_id',
        'country_id',
        'title',
        'phone',
        'email',
        'billing_type',
        'tc_no',
        'vd',
        'vkn',
        'use_for_billing',
        'e_fatura',
        'company_name',
    ];

    protected $casts = [
        'use_for_billing' => 'boolean',
        'e_fatura' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new BelongsToUserScope);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function country(){
		return $this->belongsTo(Country::class,'country_id','id');
	}

	public function state(){
		return $this->belongsTo(State::class,'state_id','id');
	}

    public function city(){
		return $this->belongsTo(City::class,'city_id','id');
	}

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }
    
}
