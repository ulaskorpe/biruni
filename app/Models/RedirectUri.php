<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedirectUri extends Model
{
    use HasFactory;

    protected $table = 'redirect_uris';

    protected $fillable = ['old','new','redirect_type'];
}
