<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->emailNumber,
            'email' => $this->email,
            'role' => $this->roles->count() > 0 ? $this->roles->first()->name : 'student'
        ];
    }
}
