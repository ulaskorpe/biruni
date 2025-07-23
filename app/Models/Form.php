<?php

namespace App\Models;

use App\Traits\HasClearCache;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Model
{
    use HasFactory,SoftDeletes, LogsActivity, HasRevisions, HasClearCache;

    protected $fillable = [
        'name',
        'language',
        'json_data',
        'sender_name',
        'to_email',
        'subject',
        'button_text',
        'success_type',
        'success_message',
        'success_uri',
        'success_script',
        'is_modal',
        'modal_button_text',
        'email_content_id',
        'cc_email',
        'bcc_email',
        'kvkk_check',
        'membership_check',
        'privacy_check',
        'step_count',
        'column_count'
    ];

    protected $casts = [
        'json_data' => 'array',
        'is_modal' => 'boolean',
        'kvkk_check' => 'boolean',
        'membership_check' => 'boolean',
        'privacy_check' => 'boolean',
    ];

    public function entries(){
        return $this->hasMany(FormEntry::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }

}
