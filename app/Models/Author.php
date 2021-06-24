<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relations
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    // Scopes
    public function scopeRetrieveAuthorsId($query, $authors)
    {
        foreach ($authors as $author) {
            $this->firstOrCreate(['name' => $author]);
        }
        return $query->whereIn('name', $authors)->get()->pluck('id');
    }
}
