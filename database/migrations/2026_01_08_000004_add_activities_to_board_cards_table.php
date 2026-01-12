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
        Schema::table('board_cards', function (Blueprint $table) {
            if (!Schema::hasColumn('board_cards', 'activities')) {
                $table->json('activities')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('board_cards', function (Blueprint $table) {
            if (Schema::hasColumn('board_cards', 'activities')) {
                $table->dropColumn('activities');
            }
        });
    }
};
