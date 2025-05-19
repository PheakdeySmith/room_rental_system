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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->integer('price');
            $table->foreignId('landlord_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('active');
            $table->softDeletes();
            $table->timestamps();
        });

            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
