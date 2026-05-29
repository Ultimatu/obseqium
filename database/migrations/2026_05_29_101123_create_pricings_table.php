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
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // 'default' pour la page tarifs
            $table->string('hero_title')->default('Tarifs & modalités commerciales');
            $table->text('hero_description')->nullable();
            $table->string('pricing_principle_title')->default('Tarification post-diagnostic');
            $table->text('pricing_principle_content')->nullable();
            $table->json('criteria')->nullable(); // 7 critères de tarification
            $table->decimal('example_total_amount', 12, 2)->default(6000000);
            $table->integer('example_duration_months')->default(6);
            $table->text('payment_terms')->nullable();
            $table->json('includes')->nullable(); // Inclusions
            $table->json('excludes')->nullable(); // Exclusions
            $table->json('process_steps')->nullable(); // 5 étapes du processus
            $table->string('offer_title')->default('Offre de lancement');
            $table->text('offer_content')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricings');
    }
};
