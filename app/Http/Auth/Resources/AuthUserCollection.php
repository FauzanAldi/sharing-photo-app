<?php

namespace App\Http\Auth\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {

        return [
            'name' => $this->name,
            'email' => $this->email
        ];
    }
}
