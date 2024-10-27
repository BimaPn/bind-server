<?php

namespace App\Models;
use App\Models\LastSeenMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ["id","sender_id","receiver_id","message", "created_at"];

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;

}
