<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'publication_year', 'genre', 'library_id'];

    /**
     * Định nghĩa quan hệ n-1: Một sách thuộc về một thư viện (library)
     */
    public function library()
    {
        // Quan hệ belongsTo tự động tìm kiếm books.library_id
        return $this->belongsTo(Library::class);
    }
}