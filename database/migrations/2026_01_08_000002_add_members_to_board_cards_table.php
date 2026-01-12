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
        if (Schema::hasTable('board_cards') && !Schema::hasColumn('board_cards', 'members')) {
            Schema::table('board_cards', function (Blueprint $table) {
                $table->json('members')->nullable()->after('attachments');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('board_cards') && Schema::hasColumn('board_cards', 'members')) {
            Schema::table('board_cards', function (Blueprint $table) {
                $table->dropColumn('members');
            });
        }
    }
};
