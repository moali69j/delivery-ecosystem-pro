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
    Schema::create('shops', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // صاحب المحل
        $table->string('name');
        $table->string('logo')->nullable();
        $table->string('address');
        $table->double('latitude'); // للموقع على الخريطة
        $table->double('longitude');
        $table->boolean('is_open')->default(true); // لفتح وإغلاق المحل
        $table->decimal('balance', 10, 2)->default(0); // رصيد المحل
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
