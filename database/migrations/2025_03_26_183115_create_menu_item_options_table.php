<?php

use App\enums\MenuOptionTypesEnum;
use App\Models\MenuItem;
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
        Schema::create('menu_item_options', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MenuItem::class)->constrained()->cascadeOnDelete();
            $table->string('name'); // "Size", "Toppings"
            $table->string('type')->default(MenuOptionTypesEnum::SELECT->value); // "select", "checkbox"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_options');
    }
};
