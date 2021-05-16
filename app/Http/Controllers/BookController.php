<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookListResource;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Image;
use App\Models\Publisher;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'can:admin'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all books
        return Cache::tags('books')->remember('book-list', now()->addMinute(), function () {
            return BookListResource::collection(Book::latest()->with(['publisher', 'authors'])->get());
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request)
    {
        // Validate request's data
        $request->validated();
        // Assign current user's id as book's user_id
        $request['user_id'] = $request->user()->id;
        // Retrieve publisher id
        $request['publisher_id'] = Publisher::retrievePublisherId($request->publisher);

        // Extract pdf file from request and store it in storage
        if ($request->hasFile('pdf_file')) {
            $request['pdf_path'] = $request->file('pdf_file')->store('book_pdf');
        }

        // Create book object
        $book = Book::create($request->all());

        // Assign the authors to the books
        $authorsId = Author::retrieveAuthorsId($request->author);
        $book->authors()->sync($authorsId);
        //Assign the categories to the books
        $categoriesId = Category::retrieveCategoriesId($request->category);
        $book->categories()->sync($categoriesId);

        // Extract images in the request and assign them to the book
        if ($request->hasFile('image')) {
            // Iterate in all given images
            foreach ($request->file('image') as $image) {
                // Store each image
                $path = $image->store('book_images');
                // Assign each image to the book
                $book->images()->save(Image::make(['path' => $path]));
            }
        }

        // Return book
        return response()->json([
            'message' => 'Book created',
            'data' => new BookResource($book)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($book)
    {
        // Retrieve requested book
        return Cache::tags('books')->remember("book-{$book}", now()->addMinute(), function () use ($book) {
            return new BookResource(Book::with(['publisher', 'authors', 'images'])->findOrFail($book));
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        // Validate request
        $request->validated();

        // Extract pdf file from request and store it in storage
        if ($request->hasFile('pdf_file')) {
            // Delete existence pdf
            if ($book->pdf_path) {
                Storage::delete($book->pdf_path);
            }
            // Store the new pdf
            $request['pdf_path'] = $request->file('pdf_file')->store('book_pdf');
        }

        // Update the book
        $book->update($request->all());

        // Return message
        return response()->json([
            'message' => 'Book updated',
            'data' => new BookResource($book)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Delete the book record
        $book->delete();

        // Return message
        return response()->json(['message' => 'Book deleted']);
    }
}
