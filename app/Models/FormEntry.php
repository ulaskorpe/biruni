<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'ip_address',
        'json_data'
    ];

    protected $casts = [
        'json_data' => 'array'
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function form(){
        return $this->belongsTo(Form::class);
    }

}
