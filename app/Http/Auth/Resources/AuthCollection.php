<?php

namespace App\Http\Auth\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthCollection extends JsonResource
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
            'access_token' => $this['access_token'],
            'refresh_token' => $this['refresh_token'],
            'user' => new AuthUserCollection($this['user'])
        ];
    }
}
