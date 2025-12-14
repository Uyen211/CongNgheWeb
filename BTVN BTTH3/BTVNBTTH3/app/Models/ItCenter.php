<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItCenter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'contact_email'];

    /**
     * Định nghĩa quan hệ 1-n: Một trung tâm tin học có nhiều thiết bị
     */
    public function hardwareDevices()
    {
        // Cần chỉ định rõ khóa ngoại là 'center_id' vì nó không theo quy tắc đặt tên mặc định của Laravel
        return $this->hasMany(HardwareDevice::class, 'center_id');
    }
}