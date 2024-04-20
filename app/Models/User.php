<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelFollow\Traits\Follower;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\File;

class User extends Authenticatable implements JWTSubject
{
    use Followable,Follower, HasApiTokens, HasFactory, Notifiable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id','name','username','phone','email',
        'password','gender','address','profile_picture','cover_photo','bio'
    ];

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public function isVerified () 
    {
        return $this->isVerified ? true : false;
    }
    public function getData ()
    {
        return [
            ...$this->only('id','name','username','profile_picture','cover_photo','bio'),
            'isVerified' => $this->isVerified(),
             'followerTotal' => $this->followers->count(),
             'followingTotal' => $this->followings->count(),
             'postTotal' => $this->posts->count(),
             'joinedAt' => $this->created_at->toDateString()
        ];
    }
    public function deleteProfilePicture ()
    {
        if($this->profile_picture != url('/storage/user/profile/default.jpg'))
        {
            $path = parse_url($this->profile_picture);
            $storagePath = public_path();
            $fullPath = $storagePath . str_replace('/','\\',$path['path']);
            File::delete($fullPath);
        }
    }
    public function deleteCoverPhoto ()
    {
        if($this->cover_photo != url('/storage/user/cover/default.jpg'))
        {
            $path = parse_url($this->cover_photo);
            $storagePath = public_path();
            $fullPath = $storagePath . str_replace('/','\\',$path['path']);
            File::delete($fullPath);
        }
    }
    // relationships

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function postLiked()
    {
        return $this->belongsToMany(Post::class, 'post_likes');
    }

    public function postSaved()
    {
        return $this->belongsToMany(Post::class, 'post_saves');
    }

    public function postComments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function groups()
    {
        return $this->hasMany(UserGroupPivot::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

}
