<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hardware_devices', function (Blueprint $table) {
            $table->id(); // Mã thiết bị (primary key) 
            $table->string('device_name'); // Tên thiết bị 
            $table->string('type'); // Loại thiết bị 
            $table->boolean('status')->default(true); // Trạng thái hoạt động 
            $table->foreignId('center_id')->constrained('it_centers')->onDelete('cascade'); 
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware_devices');
    }
};
