<?php

namespace App\Models;

use App\Models\PostSave;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','user_id','group_id','caption'
    ];

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;


    // custom methods
    public function isUserLikedPost()
    {
        return $this->likes()->where('user_id',auth()->user()->id)->exists();
    }
    public function isUsersavedPost()
    {
        return $this->saves()->where('user_id',auth()->user()->id)->exists();
    }
    public function isUserAuthor ()
    {
        return $this->author->username == auth()->user()->username;
    }
    public function getPreviewData()
    {
        return [
            'id' => $this->id,
            'user' => [
                'name' => $this->author->name,
                'profile_picture' => $this->author->profile_picture,
                'username' => $this->author->username,
                'isVerified' => $this->author->isVerified()
            ],
            'caption' => $this->caption,
            'media' => $this->media()->select('id','file_path')->get(),
            'likedTotal' => $this->likes->count(),
            'commentTotal' => $this->comments->count(),
            'isSaved' => $this->isUsersavedPost(),
            'isLiked' => $this->isUserLikedPost(),
            'isAuthor' => $this->isUserAuthor(),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
    public function getFreshPreviewData()
    {
        return [
            'id' => $this->id,
            'user' => [
                'name' => $this->author->name,
                'profile_picture' => $this->author->profile_picture,
                'username' => $this->author->username,
                'isVerified' => $this->author->isVerified()
            ],
            'caption' => $this->caption,
            'media' => $this->media()->select('id','file_path')->get(),
            'likedTotal' => 0,
            'commentTotal' => 0,
            'isSaved' => false,
            'isLiked' => false,
            'isAuthor' => true,
            'created_at' => "Just now"
        ];
    }

    // relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_likes');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }
    public function saves()
    {
        return $this->belongsToMany(User::class, 'post_saves');
    }
    public function savesPivot()
    {
        return $this->hasMany(PostSave::class);
    }

}
