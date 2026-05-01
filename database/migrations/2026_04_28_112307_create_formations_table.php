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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('cover_image')->nullable();
            $table->text('description');
            $table->longText('objectives')->nullable();
            $table->longText('program')->nullable();
            $table->text('target_audience')->nullable();
            $table->text('prerequisites')->nullable();
            $table->integer('duration_hours');
            $table->enum('format', ['presential', 'online', 'hybrid'])->default('presential');
            $table->enum('thematic', ['qualite', 'securite', 'environnement', 'reglementation', 'management'])->default('qualite');
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('price_on_request')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
