<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublisherAuthorCategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        return PublisherAuthorCategoryResource::collection(Category::with('books')->withCount('books')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'bail | required | min:3 | max:50 | string | unique:categories'
        ]);
        // Create category model
        $category = Category::create($request->all());
        // Return message
        return response()->json([
            'message' => 'Category created',
            'data' => new PublisherAuthorCategoryResource($category)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($category)
    {
        return new PublisherAuthorCategoryResource(Category::with('books')->withCount('books')->findOrFail($category));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Validate request
        $request->validate([
            'name' => 'bail | min:3 | max:50 | string | unique:categories'
        ]);
        // Update the category model
        $category->update($request->all());
        // Return message
        return response()->json([
            'message' => 'Category updated',
            'data' => new PublisherAuthorCategoryResource($category)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Delete the category model
        $category->delete();
        // Return message
        return response()->json(['message' => 'Category deleted']);
    }
}
