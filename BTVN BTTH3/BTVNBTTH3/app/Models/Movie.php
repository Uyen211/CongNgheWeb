<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'director', 'release_date', 'duration', 'cinema_id'];

    /**
     * Định nghĩa quan hệ n-1: Một phim thuộc về một rạp chiếu phim
     */
    public function cinema()
    {
        // Quan hệ belongsTo tự động tìm kiếm movies.cinema_id
        return $this->belongsTo(Cinema::class);
    }
}