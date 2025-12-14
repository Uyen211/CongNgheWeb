<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareDevice extends Model
{
    use HasFactory;

    protected $fillable = ['device_name', 'type', 'status', 'center_id'];

    /**
     * Định nghĩa quan hệ n-1: Một thiết bị thuộc về một trung tâm tin học
     */
    public function itCenter()
    {
        // Cần chỉ định rõ khóa ngoại là 'center_id'
        return $this->belongsTo(ItCenter::class, 'center_id');
    }
}