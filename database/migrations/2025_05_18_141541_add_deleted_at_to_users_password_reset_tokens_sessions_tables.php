<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes(); // adds nullable deleted_at TIMESTAMP
        });

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
