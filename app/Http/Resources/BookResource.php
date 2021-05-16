<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $pdf_url = $this->pdf_path !== null ? $this->url() : '';

        return [
            'title' => $this->title,
            'description' => $this->description,
            'year' => $this->year,
            'pdf_path' => $pdf_url,
            'publisher' => new BookAuthPubCatResource($this->publisher),
            'authors' => BookAuthPubCatResource::collection($this->authors),
            'categories' => BookAuthPubCatResource::collection($this->categories),
        ];
    }
}
