<?php

use App\enums\ReservationStatusEnum;
use App\Models\Table;
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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->nullOnDelete();
            $table->foreignIdFor(Table::class)->constrained()->nullOnDelete();
            $table->integer('party_size');
            $table->enum('status', ReservationStatusEnum::values())->default(ReservationStatusEnum::Pending->value);
            $table->datetime('date');
            $table->text('special_requests')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
