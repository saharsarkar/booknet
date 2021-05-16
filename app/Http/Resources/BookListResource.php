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
            'publisher' => new BookPublisherAuthorResource($this->publisher()->get()),
            'authors' => BookPublisherAuthorResource::collection($this->authors()->get()),
            'categories' => BookPublisherAuthorResource::collection($this->categories()->get()),
            'images' => ImageResource::collection($this->images()->get()),
        ];
    }
}
