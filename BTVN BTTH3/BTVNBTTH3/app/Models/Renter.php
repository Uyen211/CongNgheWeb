<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone_number', 'email'];

    /**
     * Định nghĩa quan hệ 1-n: Một người thuê có thể thuê nhiều laptop
     */
    public function laptops()
    {
        // Quan hệ hasMany tự động tìm kiếm laptops.renter_id
        return $this->hasMany(Laptop::class);
    }
}