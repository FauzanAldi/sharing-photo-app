<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UploadService extends Model
{
    use HasFactory, SoftDeletes;

    // Define the table name
    protected $table = 'file_upload_temporary';

    // Define the fillable columns
    protected $fillable = [
        'path', 'name'
    ];

    // Define the hidden columns
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    // Save data to database
    public static function saveData($path, $name)
    {
        $data = self::create([
            'path' => $path,
            'name' => $name,
        ]);

        return $data;
    }

    // Remove aws url
    public static function removeAwsUrlMultiple($photos)
    {
        $currentPhoto = [];
        foreach ($photos as $photo) {
            $currentPhoto[] = str_replace(env('STORAGE_URL'), '', $photo);
        }

        return $currentPhoto;
    }

    // Remove aws url
    public static function removeAwsUrl($photo)
    {
        return str_replace(env('STORAGE_URL'), '', $photo);
    }
}
