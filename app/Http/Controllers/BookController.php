<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookListResource;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
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
        return BookListResource::collection(Book::latest()->with(['publisher', 'authors'])->get());
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

        // Extract image file from request and store it in storage
        if ($request->hasFile('thumbnail')) {
            $request['image'] = $request->file('thumbnail')->store('books/image');
        }
        // Extract pdf file from request and store it in storage
        if ($request->hasFile('pdf_file')) {
            $request['pdf'] = $request->file('pdf_file')->store('books/pdf');
        }

        // Create book object
        $book = Book::create($request->all());

        // Assign the authors to the books
        $authorsId = Author::retrieveAuthorsId($request->author);
        $book->authors()->sync($authorsId);
        //Assign the categories to the books
        $categoriesId = Category::retrieveCategoriesId($request->category);
        $book->categories()->sync($categoriesId);

        // Return book
        return response()->json([
            'message' => 'Book created',
            'book' => new BookResource($book)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($book)
    {
        // Retrieve requested book
        return new BookResource(Book::with(['publisher', 'authors'])->findOrFail($book));
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
            if ($book->pdf) {
                Storage::delete($book->pdf);
            }
            // Store the new pdf
            $request['pdf'] = $request->file('pdf_file')->store('book_pdf');
        }
        // Extract image file from request and store it in storage
        if ($request->hasFile('image')) {
            // Delete existence image
            if ($book->image) {
                Storage::delete($book->image);
            }
            // Store the new pdf
            $request['image'] = $request->file('image')->store('book/image');
        }

        // Update the book
        $book->update($request->all());

        if ($request->author) {
            // Assign the authors to the books
            $authorsId = Author::retrieveAuthorsId($request->author);
            $book->authors()->sync($authorsId);
        }
        if ($request->category) {
            //Assign the categories to the books
            $categoriesId = Category::retrieveCategoriesId($request->category);
            $book->categories()->sync($categoriesId);
        }

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
        // delete existing book image
        if (!is_null($book->image)) {
            Storage::delete($book->image);
        }
        // delete existing book pdf
        if (!is_null($book->pdf)) {
            Storage::delete($book->pdf);
        }
        // Delete the book record
        $book->delete();

        // Return message
        return response()->json(['message' => 'Book deleted']);
    }
}
