<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterMember extends Model
{
    use HasFactory;

    protected $table = 'newsletter_members';

    protected $fillable = ['name','email','ip'];
}
