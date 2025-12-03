<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            // Drop existing foreign key constraint
            $table->dropForeign(['user_id']);
        });

        Schema::table('tools', function (Blueprint $table) {
            // Make column nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            // Recreate foreign key with null on delete
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            // Drop modified foreign key
            $table->dropForeign(['user_id']);
        });

        Schema::table('tools', function (Blueprint $table) {
            // Revert to not nullable and cascade delete
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }
};
