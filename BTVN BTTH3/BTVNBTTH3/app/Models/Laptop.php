<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;

    protected $fillable = ['brand', 'model', 'specifications', 'rental_status', 'renter_id'];

    /**
     * Định nghĩa quan hệ n-1: Một laptop thuộc về một người thuê
     */
    public function renter()
    {
        // Quan hệ belongsTo tự động tìm kiếm laptops.renter_id
        return $this->belongsTo(Renter::class);
    }
}