<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    // Relations
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Scopes
    public function url()
    {
        return Storage::url($this->path);
    }
}
