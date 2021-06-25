<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Stichoza\GoogleTranslate\GoogleTranslate;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        // Filter authenticated user and guest user
        if ($this->user) {
            $user = [
                'id' => $this->user->id,
                'username' => $this->user->username
            ];
        } else {
            $user = $this->user_name;
        }

        return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => GoogleTranslate::trans(Carbon::parse($this->created_at)->diffForHumans(), 'fa'),
            'user' => $user,
        ];
    }
}
