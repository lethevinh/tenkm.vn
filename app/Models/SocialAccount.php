<?php

namespace App\Models;

class SocialAccount extends Model
{
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    protected $table = 'social_accounts';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
