<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'user_id',
        'language',
        'notification_email',
        'notification_sms',
        'notification_app',
        'privacy_profile',
        'privacy_contact',
        'theme',
        'layout'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
