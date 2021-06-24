<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relations
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    // Scopes

    /**
     * Return publisher id.
     * If given publisher does not exits in database, create it
     */
    public function scopeRetrievePublisherId($query, $publisher)
    {
        return $this->firstOrCreate(['name' => $publisher])->id;
    }
}
