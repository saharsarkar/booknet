<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Models\Book;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Book $book)
    {
        return Cache::tags('images')->remember("book-{$book->id}-image-list", now()->addMinute(), function () use ($book) {
            return ImageResource::collection($book->images);
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        // Extract image in the request and assign it to the book
        if ($request->hasFile('image')) {
            // Store the image in storage
            $path = $request->file('image')->store('book_images');
            $image = Image::make(['path' => $path]);
            $book->images()->save($image);
        }

        return response()->json([
            'message' => 'Image created',
            'data' => ['path' => $image->url()],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book, Image $image)
    {
        return Cache::tags('images')->remember("book-{$book->id}-image-{$image->id}", now()->addMinute(), function () use ($image) {
            return new ImageResource($image);
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book, Image $image)
    {
        // Extract images in the request and assign them to the book
        if ($request->hasFile('image')) {
            // Delete image from storage
            Storage::delete($image->path);
            // Store new image in storage
            $path = $request->file('image')->store('book_images');
            // $book->images()->save(Image::make(['path' => $path]));
            $image->update(['path' => $path]);
        }

        return response()->json([
            'message' => 'Image updated',
            'data' => new ImageResource($image),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book, Image $image)
    {
        // Delete image from storage
        Storage::delete($image->path);
        // Delete the image model
        $image->delete();

        return response()->json(['message' => 'Image deleted']);
    }
}
