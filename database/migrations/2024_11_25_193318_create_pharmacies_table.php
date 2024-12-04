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
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الصيدلية
            $table->string('address'); // العنوان
            $table->decimal('latitude', 10, 8); // خط العرض
            $table->decimal('longitude', 11, 8); // خط الطول
            $table->decimal('rating', 2, 1)->default(0); // تقييم النجوم
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies');
    }
};
