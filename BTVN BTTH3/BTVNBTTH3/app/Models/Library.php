<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    // Các trường được phép gán hàng loạt (Mass Assignment)
    protected $fillable = ['name', 'address', 'contact_number'];

    /**
     * Định nghĩa quan hệ 1-n: Một thư viện có nhiều sách (books)
     */
    public function books()
    {
        // Quan hệ hasMany tự động tìm kiếm books.library_id
        return $this->hasMany(Book::class);
    }
}