<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        $pdf_url = $this->pdf ? $this->pdf_url() : '';
        $image_url = $this->image ? $this->image_url() : '';

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'year' => $this->year,
            'image' => $image_url,
            'pdf' => $pdf_url,
            'digikala' => $this->digikala,
            'publisher' => new BookAuthPubCatResource($this->publisher),
            'authors' => BookAuthPubCatResource::collection($this->authors),
            'categories' => BookAuthPubCatResource::collection($this->categories),
            'comments' => $this->getComments($this),
        ];
    }

    private function getComments($book)
    {
        $reviewerComments = CommentResource::collection($book->comments()->reviewerComments());
        $userComments = CommentResource::collection($book->comments()->userComments());
        $guestComments = CommentResource::collection($book->guestComments);

        $otherComments = $userComments->merge($guestComments);

        return [
            'reviewerComments' => $reviewerComments,
            'otherComments' => $otherComments,
        ];
    }
}
