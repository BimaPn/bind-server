<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','user_id','post_id'
    ];

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;
}
