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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->constrained('users');
        $table->foreignId('shop_id')->constrained('shops');
        $table->foreignId('driver_id')->nullable()->constrained('users'); // يمكن أن يكون فارغاً في البداية
        
        $table->decimal('subtotal', 10, 2); // سعر المنتجات
        $table->decimal('delivery_fee', 10, 2); // رسوم التوصيل
        $table->decimal('total_price', 10, 2); // الإجمالي
        
        $table->enum('status', ['pending', 'accepted', 'preparing', 'picked_up', 'delivered', 'cancelled'])->default('pending');
        
        $table->text('customer_notes')->nullable(); // ملاحظات الزبون
        $table->string('change_needed')->nullable(); // طلب "الفكة"
        
        $table->double('delivery_lat')->nullable(); // موقع التوصيل
        $table->double('delivery_long')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
