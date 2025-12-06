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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('contact_email')->nullable()->after('github_url');
            $table->string('linkedin_url')->nullable()->after('contact_email');
            $table->string('twitter_url')->nullable()->after('linkedin_url');
            $table->string('instagram_url')->nullable()->after('twitter_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['contact_email', 'linkedin_url', 'twitter_url', 'instagram_url']);
        });
    }
};
