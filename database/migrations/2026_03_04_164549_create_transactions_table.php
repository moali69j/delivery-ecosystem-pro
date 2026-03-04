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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users'); // صاحب العملية (سواء محل أو دليفري)
        $table->decimal('amount', 10, 2); // المبلغ
        $table->enum('type', ['deposit', 'withdraw']); // إيداع (أرباح) أو سحب (ديون/عمولة)
        $table->string('description'); // مثلاً: "عمولة طلب رقم #102"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
