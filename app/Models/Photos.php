<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photos extends Model
{
    use HasFactory, SoftDeletes;

    // Define table name
    protected $table = 'photos';

    // Define fillable fields
    protected $fillable = [
        'user_id', 'photos', 'caption'
    ];

    // Define hidden fields
    protected $hidden = [
        'updated_at', 'deleted_at'
    ];

    public function getPhotosAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return env('STORAGE_URL') . $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->hasMany(PhotosTags::class, 'photos_id');
    }

    public function like()
    {
        return $this->hasMany(PhotosLikes::class, 'photos_id');
    }

    public function insertOrUpdatePhoto($id=null, $user_id, $photos, $caption, $tags){

        $photo = $id ? SELF::find($id) : new SELF;

        $photo->user_id = $user_id;
        $photo->photos = $photos;
        $photo->caption = $caption;
        $photo->save();

        if(count($tags)>0){
            
            if($id){
                PhotosTags::where('photos_id', $id)->delete();
            }

            foreach ($tags as $key => $value) {
                
                PhotosTags::create([
                    'photos_id' => $photo->id,
                    'tags' => $value
                ]);

            }

        }

        return $photo;
        
    }

}