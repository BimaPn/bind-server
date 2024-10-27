<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
class PostMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','post_id','file_path'
    ];

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;

    // custom methods
    public function deleteFile ()
    {
        $path = parse_url($this->file_path);
        $storagePath = public_path();
        $fullPath = $storagePath . str_replace('/','\\',$path['path']);
        File::delete($fullPath);
    }
    // relationships
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
