<?php

use App\enums\OrderStatusEnum;
use App\enums\OrderTypesEnum;
use App\enums\PaymentMethodsEnum;
use App\enums\PaymentStatusEnum;
use App\Models\User;
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
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->enum('order_type', OrderTypesEnum::values());
            $table->enum('status', OrderStatusEnum::values())->default(OrderStatusEnum::Pending->value);
            $table->integer('total_amount')->default(0);
            $table->enum("payment_status", PaymentStatusEnum::values())->default(PaymentStatusEnum::Pending->value);
            $table->enum('payment_method', PaymentMethodsEnum::values())->default(PaymentMethodsEnum::Cash->value);
            $table->text("notes")->nullable();
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
