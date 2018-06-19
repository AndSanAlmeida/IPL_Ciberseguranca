<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SmallerUserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'reason' => $this->blocked ? $this->reason_blocked : $this->reason_reactivated,
            'type' => $this->type,
        ];
    }
}
