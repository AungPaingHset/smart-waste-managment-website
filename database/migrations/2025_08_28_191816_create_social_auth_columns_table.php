<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('social_users', function (Blueprint $table) {
            $table->string('github_id')->nullable()->unique();
            $table->string('google_id')->nullable()->unique();  
            $table->string('facebook_id')->nullable()->unique();
            $table->string('provider')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('last_login_at')->nullable();
            
            // Make password nullable for social users
            $table->string('password')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('social_users', function (Blueprint $table) {
            $table->dropColumn([
                'github_id',
                'google_id',
                'facebook_id', 
                'provider',
                'avatar',
                'last_login_at'
            ]);
        });
    }
};
