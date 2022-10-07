<?php

namespace App\Http\Resources;

use App\Enums\UserStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'status' => UserStatus::from($this->status)->name,
            'profile_image_url' => $this->profile_image_url,
        ];
    }
}
