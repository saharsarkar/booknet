<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublisherAuthorCategoryResource;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
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
        return PublisherAuthorCategoryResource::collection(Publisher::with('books')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'name' => 'bail | required | min:5 | max:100 | string | unique:publishers'
        ]);

        // Create new record
        $publisher = Publisher::create($request->all());

        // Return message
        return response()->json([
            'message' => 'Publisher created',
            'data' => new PublisherAuthorCategoryResource($publisher)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($publisher)
    {
        return new PublisherAuthorCategoryResource(Publisher::with('books')->findOrFail($publisher));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        // validate request
        $request->validate([
            'name' => 'bail | min:5 | max:100 | string | unique:publishers'
        ]);
        // Update the publisher
        $publisher->update($request->all());

        // Return message
        return response()->json([
            'message' => 'Publisher updated',
            'data' => new PublisherAuthorCategoryResource($publisher)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        // Delete the publisher record
        $publisher->delete();
        // Return message
        return response()->json(['message' => 'Publisher deleted']);
    }
}
