<?php

namespace App\Http\UploadService;

use Illuminate\Http\Resources\Json\JsonResource;

class UploadServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'path' => $this['path'],
            'full_path' => env('STORAGE_URL') . $this['path'],
            'original_name' => $this['name'],
        ];
    }
}
