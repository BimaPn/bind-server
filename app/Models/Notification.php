<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public function sender () : BelongsTo
    {
        return $this->belongsTo(User::class,"sender_id");
    }

    public function notifier () : BelongsTo
    {
        return $this->belongsTo(User::class,"notifier_id");
    }

    public function entity () : BelongsTo
    {
        return $this->belongsTo(NotificationObject::class, "notification_object_id");
    }
}
