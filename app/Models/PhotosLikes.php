<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhotosLikes extends Model
{
    use HasFactory, SoftDeletes;

    // Define table name
    protected $table = 'photos_like';

    // Define fillable fields
    protected $fillable = [
        'photos_id', 'user_id'
    ];

    // Define hidden fields
    protected $hidden = [
        'updated_at', 'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function photos()
    {
        return $this->belongsTo(Photos::class, 'photos_id');
    }

    public function likePhoto($user_id, $photos_id){

        $data = [
            'photos_id' => $photos_id,
            'user_id' => $user_id
        ];

        $check = SELF::where($data)->select('id')->first();

        if(!$check){
            SELF::create($data);
        }
        
    }

    public function dislikePhoto($user_id, $photos_id){
        SELF::where([
            'photos_id' => $photos_id,
            'user_id' => $user_id
        ])->delete();
    }

}