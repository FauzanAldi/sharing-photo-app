<?php

namespace App\Http\Photos;

use Illuminate\Http\Resources\Json\JsonResource;

class PhotosResource extends JsonResource
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
            'id' => $this->id,
            'photos' => $this->photos,
            'title' => $this->caption,
            'tags' => $this->tags->pluck('tags'),
            'like' => $this->like->count(),
            'created_at' => $this->created_at,
        ];
    }
}
