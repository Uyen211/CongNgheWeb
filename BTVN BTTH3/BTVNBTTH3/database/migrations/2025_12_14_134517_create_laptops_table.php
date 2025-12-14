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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id(); // Mã laptop (primary key) 
            $table->string('brand'); // Hãng sản xuất 
            $table->string('model'); // Mẫu laptop 
            $table->string('specifications'); // Thông số kỹ thuật 
            $table->boolean('rental_status')->default(false); // Trạng thái cho thuê 
            $table->foreignId('renter_id')->constrained('renters')->onDelete('cascade'); // FK tham chiếu renters.id 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
