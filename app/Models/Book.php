<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'author_id',
        'genre_id',
        'title',
        'slug',
        'description',
        'cover_image',
        'pdf_path',
        'publication_year',
        'status'
    ];

    protected $casts = [
        'publication_year' => 'integer',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Category::class, 'book_genre', 'book_id', 'genre_id');
    }
}
