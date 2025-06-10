<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('price_overrides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_type_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->date('start_date'); // The first day the override is active
            $table->date('end_date');   // The last day the override is active
            $table->string('reason')->nullable(); // e.g., "Water Festival", "Khmer New Year"
            $table->timestamps();

            // Index for faster lookups
            $table->index(['property_id', 'room_type_id', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_overrides');
    }
};
