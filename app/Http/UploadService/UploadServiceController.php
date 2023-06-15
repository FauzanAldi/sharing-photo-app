<?php

namespace App\Http\UploadService;

use App\Http\Controllers\Controller;

use App\Models\UploadService;

use App\Http\Resources\MessageErrorResource;
use App\Http\UploadService\UploadServiceFileRequest;
use App\Http\UploadService\UploadServiceImageRequest;

use Illuminate\Support\Facades\Storage;

class UploadServiceController extends Controller
{
    /**
     * Create a new UploadServiceController instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Upload image to S3
     *
     * @param UploadServiceImageRequest $request
     * @return UploadServiceResource | \Illuminate\Http\JsonResponse
     */
    public function uploadImage(UploadServiceImageRequest $request, $typeupload)
    {
        // Get the image from the request
        $image = $request->file('image');
        $originalName = $image->getClientOriginalName();

        // Create a path for the image
        $path = "assets/image/$typeupload/" . $image->hashName();

        // Upload the image to S3
        try {
            Storage::disk()->put('public/'.$path, file_get_contents($image), 'public');
        } catch (\Exception $e) {
            return new MessageErrorResource([
                'code' => "S3_UPLOAD_FAILED",
                'message' => 'Could not upload image',
                'details' => $e->getMessage(),
            ]);
        }

        $uploadedImage = UploadService::saveData($path, $originalName);

        // Return the image path
        return new UploadServiceResource([
            'path' => $uploadedImage->path,
            'name' => $uploadedImage->name,
        ]);
    }

    /**
     * Upload file to S3
     *
     * @param UploadServiceFileRequest $request
     * @return UploadServiceResource | \Illuminate\Http\JsonResponse
     */

    public function uploadFile(UploadServiceFileRequest $request, $typeupload)
    {
        // Get the file from the request
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        // Create a path for the file
        $path = "assets/file/$typeupload/" . $file->hashName();

        // Upload the file to S3
        try {
            Storage::disk()->put('public/'.$path, file_get_contents($file), 'public');
        } catch (\Exception $e) {
            return new MessageErrorResource([
                'code' => "S3_UPLOAD_FAILED",
                'message' => 'Could not upload file',
                'details' => $e->getMessage(),
            ]);
        }

        $uploadedFile = UploadService::saveData($path, $originalName);

        // Return the file path
        return new UploadServiceResource([
            'path' => $uploadedFile->path,
            'name' => $uploadedFile->name,
        ]);
    }
}
