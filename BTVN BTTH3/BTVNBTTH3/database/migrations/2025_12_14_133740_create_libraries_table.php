<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->id(); // [cite: 4]
            $table->string('name'); // [cite: 7]
            $table->string('address'); // [cite: 8]
            $table->string('contact_number'); // [cite: 9]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libraries');
    }
};
