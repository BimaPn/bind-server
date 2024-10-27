<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroupPivot extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'group_id',
        'group_role_id',
        'user_group_status_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function status()
    {
        return $this->belongsTo(UserGroupStatus::class, 'user_group_status_id');
    }

    public function role()
    {
        return $this->belongsTo(GroupRole::class, 'group_role_id');
    }
}
