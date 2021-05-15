<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function created(Category $category)
    {
        Cache::tags(['categories'])->forget('category-list');
    }

    public function updating(Category $category)
    {
        Cache::tags(['categories'])->forget('category-list');
        Cache::tags(['categories'])->forget("category-{$category->id}");
    }

    public function deleting(Category $category)
    {
        Cache::tags(['categories'])->forget('category-list');
        Cache::tags(['categories'])->forget("category-{$category->id}");
    }
}
