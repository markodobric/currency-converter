<?php

use App\Models\Currency;
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
            $table->foreignIdFor(Currency::class, 'base_currency_id')
                ->constrained('currencies')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignIdFor(Currency::class, 'foreign_currency_id')
                ->constrained('currencies')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->decimal('base_currency_amount', total: 20, places: 6, unsigned: true);
            $table->decimal('foreign_currency_amount', total: 20, places: 6, unsigned: true);
            $table->decimal('foreign_currency_exchange_rate', total: 20, places: 6, unsigned: true);
            $table->decimal('surcharge_percentage')->nullable()->default(null);
            $table->decimal('surcharge_amount', total: 20, places: 6, unsigned: true)->nullable()->default(null);
            $table->decimal('discount_percentage')->nullable()->default(null);
            $table->decimal('discount_amount', total: 20, places: 6, unsigned: true)->nullable()->default(null);
            $table->decimal('total', total: 20, places: 6, unsigned: true);
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
