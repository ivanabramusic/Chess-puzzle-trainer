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
        Schema::table('puzzles', function (Blueprint $table) {
            $table->enum('plays_first', ['white', 'black'])->default('white');
        });
    }

    public function down(): void
    {
        Schema::table('puzzles', function (Blueprint $table) {
            $table->dropColumn('plays_first');
        });
    }
};
