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
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'avatar' => $this->avatar,
            'blocked' => $this->blocked,
            'activated' => $this->activated,
            'reason_blocked' => $this->reason_blocked,
            'reason_reactivated' => $this->reason_reactivated,
            'total_forum_posts' => $this->total_forum_posts,
            'total_forum_comments' => $this->total_forum_comments,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
