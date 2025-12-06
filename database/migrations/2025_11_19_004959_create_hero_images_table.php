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
        Schema::create('hero_images', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique(); // 'central', 'icon_angular', 'icon_js', 'icon_python'
            $table->string('image_url')->nullable();
            $table->string('required_size')->nullable(); // Ej: '800x1000', '64x64'
            $table->text('description')->nullable(); // Descripción del tamaño requerido
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_images');
    }
};
