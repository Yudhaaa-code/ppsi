<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('board_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->integer('position')->default(0);
            $table->timestamps();
        });

        Schema::table('board_cards', function (Blueprint $table) {
            $table->foreignId('board_list_id')->nullable()->constrained()->cascadeOnDelete()->after('user_id');
        });

        // Migrate existing data
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            // Create default lists
            $todayId = DB::table('board_lists')->insertGetId([
                'user_id' => $user->id,
                'title' => 'Today',
                'position' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $weeklyId = DB::table('board_lists')->insertGetId([
                'user_id' => $user->id,
                'title' => 'Weekly',
                'position' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $laterId = DB::table('board_lists')->insertGetId([
                'user_id' => $user->id,
                'title' => 'Later',
                'position' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update cards
            // Check if list_key column exists before querying (it should, but safety first)
            if (Schema::hasColumn('board_cards', 'list_key')) {
                DB::table('board_cards')
                    ->where('user_id', $user->id)
                    ->where('list_key', 'today')
                    ->update(['board_list_id' => $todayId]);

                DB::table('board_cards')
                    ->where('user_id', $user->id)
                    ->where('list_key', 'weekly')
                    ->update(['board_list_id' => $weeklyId]);

                DB::table('board_cards')
                    ->where('user_id', $user->id)
                    ->where('list_key', 'later')
                    ->update(['board_list_id' => $laterId]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('board_cards', function (Blueprint $table) {
            $table->dropForeign(['board_list_id']);
            $table->dropColumn('board_list_id');
        });
        Schema::dropIfExists('board_lists');
    }
};
