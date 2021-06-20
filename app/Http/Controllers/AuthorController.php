<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublisherAuthorCategoryResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
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
        return PublisherAuthorCategoryResource::collection(Author::with('books')->withCount('books')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'bail | required | min:3 | max:50 | string'
        ]);
        // Create author model
        $author = Author::create($request->all());
        // Return message
        return response()->json([
            'message' => 'Author created',
            'data' => new PublisherAuthorCategoryResource($author)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($author)
    {
        return new PublisherAuthorCategoryResource(Author::with('books')->withCount('books')->findOrFail($author));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        // Validate request
        $request->validate([
            'name' => 'bail | min:3 | max:50 | string'
        ]);
        // Update the author model
        $author->update($request->all());
        // Return message
        return response()->json([
            'message' => 'Author updated',
            'data' => new PublisherAuthorCategoryResource($author)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        // Delete the author model
        $author->delete();
        // Return message
        return response()->json(['message' => 'Author deleted']);
    }
}
