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
        Schema::table('users', function (Blueprint $table) {
            // Rename password_hash to password
            if (Schema::hasColumn('users', 'password_hash') && !Schema::hasColumn('users', 'password')) {
                DB::statement('ALTER TABLE users CHANGE password_hash password VARCHAR(255)');
            }
            
            // Add email_verified_at if not exists
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
            
            // Add updated_at if not exists
            if (!Schema::hasColumn('users', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });
        
        // Update role to enum if it's still varchar
        try {
            $roleColumn = DB::select("SHOW COLUMNS FROM users WHERE Field = 'role'")[0] ?? null;
            if ($roleColumn && strpos(strtolower($roleColumn->Type), 'enum') === false) {
                // Update existing data first if needed
                DB::statement("UPDATE users SET role = 'customer' WHERE role NOT IN ('customer', 'developer', 'admin') OR role IS NULL");
                
                // Change to enum
                DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('customer', 'developer', 'admin') DEFAULT 'customer'");
            }
        } catch (\Exception $e) {
            // Continue if modification fails
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverse changes if needed
            if (Schema::hasColumn('users', 'password') && !Schema::hasColumn('users', 'password_hash')) {
                DB::statement('ALTER TABLE users CHANGE password password_hash VARCHAR(255)');
            }
        });
    }
};
