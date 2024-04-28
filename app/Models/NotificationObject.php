<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationObject extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public function type () : BelongsTo
    {
        return $this->belongsTo(NotificationType::class, "notification_type_id");
    }
}
