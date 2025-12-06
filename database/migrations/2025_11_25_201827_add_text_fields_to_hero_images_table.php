<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('hero_images', function (Blueprint $table) {
            $table->string('badge_text')->nullable()->after('description');
            $table->text('title')->nullable()->after('badge_text');
            $table->text('subtitle')->nullable()->after('title');
        });
    }

    public function down()
    {
        Schema::table('hero_images', function (Blueprint $table) {
            $table->dropColumn(['badge_text', 'title', 'subtitle']);
        });
    }
};
