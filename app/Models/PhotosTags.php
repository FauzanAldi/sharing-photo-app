<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhotosTags extends Model
{
    use HasFactory, SoftDeletes;

    // Define table name
    protected $table = 'photos_tags';

    // Define fillable fields
    protected $fillable = [
        'photos_id', 'tags'
    ];

    // Define hidden fields
    protected $hidden = [
        'updated_at', 'deleted_at'
    ];

    public function photos()
    {
        return $this->belongsTo(Photos::class, 'photos_id');
    }

}