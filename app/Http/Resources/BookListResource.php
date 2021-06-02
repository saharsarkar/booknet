<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'year' => $this->year,
            'url' => route('book.show', ['book' => $this->id]),
            'publisher' => new BookAuthPubCatResource($this->publisher()->get()),
            'authors' => BookAuthPubCatResource::collection($this->authors()->get()),
            'categories' => BookAuthPubCatResource::collection($this->categories()->get()),
            'images' => ImageResource::collection($this->images()->get()),
        ];
    }
}
