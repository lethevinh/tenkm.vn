<?php

namespace App\Models;

use App\Traits\Categorizable;
use App\Traits\Metadatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, Categorizable,
        HasApiTokens, Metadatable;

    const TYPES = ['member' => 'Member', 'guest' => 'Guest'];

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'type_lb', 'avatar', 'username', 'address', 'description', 'phone',
        'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getImageAttribute()
    {
        $disk = Storage::disk(config('admin.upload.disk'));
        $avatar = $this->attributes['avatar'];
        if (!empty($avatar) && !URL::isValidUrl($avatar) && $disk->exists($avatar)) {
            return $disk->url($avatar);
        }
        return $avatar;
    }

    public function getLinkAttribute()
    {
        return route('user.profile.show', ['user' => $this]);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($user) {
            $user->metas()->create([
                'key_lb' => 'company',
                'value_lb' => 'Company'
            ]);
            $user->metas()->create([
                'key_lb' => 'facebook',
                'value_lb' => 'https://www.facebook.com/' . $user->username
            ]);
            $user->metas()->create([
                'key_lb' => 'twitter',
                'value_lb' => 'https://www.twitter.com/' . $user->username
            ]);
            $user->metas()->create([
                'key_lb' => 'instagram',
                'value_lb' => 'https://www.instagram.com/' . $user->username
            ]);
            $user->metas()->create([
                'key_lb' => 'skype',
                'value_lb' => 'https://www.skype.com/' . $user->username
            ]);
            $user->metas()->create([
                'key_lb' => 'youtube',
                'value_lb' => 'https://www.youtube.com/' . $user->username
            ]);
            $user->metas()->create([
                'key_lb' => 'website',
                'value_lb' => 'https://' . $user->username. '.com'
            ]);
        });
        static::deleted(function ($user) {
            $user->socials()->delete();
        });
    }

    public function socials() {
        return $this->hasMany(SocialAccount::class, 'user_id');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type_lb', $type);
    }

    public static function makeUser($user) {
        $className = "App\\Models\\".ucfirst($user->type_lb);
       if ( class_exists($className)) {
           return $className::find($user->id);
       }
       return  $user;
    }

    /**
     * @return array
     */
    public function toInfo() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'avatar' => $this->image,
            'type' => $this->type_lb
        ];
    }
}
