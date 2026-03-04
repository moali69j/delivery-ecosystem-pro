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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone')->unique(); // رقم الهاتف للتواصل
        $table->string('password');
        // الأدوار: زبون، صاحب محل، دليفري، مدير منطقة، أدمن
        $table->enum('role', ['customer', 'shop_owner', 'driver', 'area_manager', 'admin'])->default('customer');
        $table->string('avatar')->nullable(); // صورة الملف الشخصي
        $table->boolean('is_active')->default(true); // لتعطيل الحسابات
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
