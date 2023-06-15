<?php

namespace App\Http\Photos;

use App\Http\Controllers\Controller;

use App\Models\Photos;
use App\Models\PhotosLikes;

use App\Http\Photos\Request\StorePhotosRequest;
use App\Http\Photos\Request\UpdatePhotosRequest;
use App\Http\Photos\Request\LikeDislikePhotoRequest;

use App\Http\Resources\MessageErrorResource;
use App\Http\Resources\MessageResponseResource;

use Auth;

class PhotosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        // Get all photos
        $photo = Photos::all();

        return PhotosResource::collection($photo);
    }

    public function store(StorePhotosRequest $request)
    {   
        $requestData = $request->validated();

        // Store the photo
        $photo = (new Photos)->insertOrUpdatePhoto(null, Auth::user()->id, $requestData['photos'], $requestData['caption'], (isset($requestData['tags']) ? $requestData['tags'] : []));

        return new PhotosResource($photo);
    }

    public function show(int $id)
    {
        // Check if the photo exists
        if (!$photo = Photos::find($id)) {
            return $this->errorResponse('PHOTOS_NOT_FOUND');
        }

        return new PhotosResource($photo);
    }

    public function update(UpdatePhotosRequest $request, int $id)
    {
        // Check if the photo exists
        if (!$photo = Photos::find($id)) {
            return $this->errorResponse('PHOTOS_NOT_FOUND');
        }

        $requestData = $request->validated();

        // Update the photo
        $photo = (new Photos)->insertOrUpdatePhoto($id, Auth::user()->id, $requestData['photos'], $requestData['caption'], (isset($requestData['tags']) ? $requestData['tags'] : []));

        return new PhotosResource($photo);
    }

    public function destroy(int $id)
    {
        // Check if the photo exists
        if (!$photo = Photos::find($id)) {
            return $this->errorResponse('PHOTOS_NOT_FOUND');
        }

        // Delete the photo
        $photo->delete();

        return (new MessageResponseResource([
            'message' => 'PHOTOS deleted successfully',
            'status' => 200,
        ]));
    }

    public function likePhoto($id)
    {   
        // Check if the photo exists
        if (!$photo = Photos::find($id)) {
            return $this->errorResponse('PHOTOS_NOT_FOUND');
        }

        $likes = (new PhotosLikes)->likePhoto(Auth::user()->id, $id);

        $photo = Photos::find($id);

        return new PhotosResource($photo);
    }

    public function dislikePhoto(int $id)
    {   
        // Check if the photo exists
        if (!$photo = Photos::find($id)) {
            return $this->errorResponse('PHOTOS_NOT_FOUND');
        }

        $likes = (new PhotosLikes)->dislikePhoto(Auth::user()->id, $id);

        $photo = Photos::find($id);

        return new PhotosResource($photo);
    }

    function errorResponse($code)
    {
        $errCode = 400;

        switch ($code) {
            case 'PHOTOS_NOT_FOUND':
                $errCode = 404;
                $message = 'PHOTOS not found';
                break;

            default:
                $message = $code;
                $code = 'UNKNOWN_ERROR';
                $errCode = 500;
                break;
        }

        return (new MessageErrorResource([
            'code' => $code,
            'message' => $message,
        ]))->response()->setStatusCode($errCode);
    }
}
