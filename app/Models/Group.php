<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'group_picture'
    ];

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;

    // methods
    public function isUserJoinGroup()
    {
        return $this->users()->where('user_id', auth()->user()->id)->exists();
    }

    public function isUserGroupAdmin()
    {
        return $this->users()->where([['user_id', auth()->user()->id], ['group_role_id', 3]])->exists();
    }

    public function isUserBanned()
    {
        return $this->users()->where([['user_id', auth()->user()->id], ['user_group_status_id', 2]])->exists();
    }

    public function usersBanned()
    {
        return $this->users()->where('user_group_status_id', 2)->get();
    }

    public function getPreviewData()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'group_picture' => $this->group_picture,
            'memberTotal' => $this->users->count(),
            'isJoin' => $this->isUserJoinGroup()
        ];
    }
    public function getDetailData()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'group_picture' => $this->group_picture,
            'memberTotal' => $this->users->count(),
            'isJoin' => $this->isUserJoinGroup(),
            'isAdmin' => $this->isUserGroupAdmin()
        ];
    }
    public function deleteGroupPicture()
    {
        if ($this->group_picture != url('/storage/group/picture/default.jpg')) {
            $path = parse_url($this->group_picture);
            $storagePath = public_path();
            $fullPath = $storagePath . str_replace('/', '\\', $path['path']);
            File::delete($fullPath);
        }
    }

    // relationships
    public function users()
    {
        return $this->hasMany(UserGroupPivot::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
