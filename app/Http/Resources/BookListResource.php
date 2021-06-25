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
            'year' => $this->year,
            'description' => $this->description,
            'image' => $this->image ? $this->image_url() : '',
            'pdf' => $this->pdf ? $this->pdf_url() : '',
            'publisher' => new BookAuthPubCatResource($this->publisher),
            'authors' => BookAuthPubCatResource::collection($this->authors),
            'categories' => BookAuthPubCatResource::collection($this->categories),
        ];
    }
}
