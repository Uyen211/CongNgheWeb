<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'total_seats'];

    /**
     * Định nghĩa quan hệ 1-n: Một rạp chiếu phim có nhiều phim
     */
    public function movies()
    {
        // Quan hệ hasMany tự động tìm kiếm movies.cinema_id
        return $this->hasMany(Movie::class);
    }
}