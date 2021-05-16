<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookAuthPubCatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Filter models based on table name to generate the model url
        if ($this->getTable() === 'authors') {
            $url = route('author.show', ['author' => $this->id]);
        } else if ($this->getTable() === 'publishers') {
            $url = route('publisher.show', ['publisher' => $this->id]);
        } else {
            $url = route('category.show', ['category' => $this->id]);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $url
        ];
    }
}
