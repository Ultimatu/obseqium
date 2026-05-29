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
        Schema::create('diagnostic_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();

            // Client info
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone')->nullable();
            $table->string('client_company')->nullable();
            $table->text('client_address')->nullable();

            // Company profile
            $table->string('sector')->nullable();
            $table->string('company_size')->nullable(); // micro, small, medium, large
            $table->json('requested_standards')->nullable(); // ISO 9001, 14001, 45001, etc.

            // Diagnostic scheduling
            $table->date('requested_date')->nullable();
            $table->date('scheduled_date')->nullable();
            $table->date('completed_date')->nullable();

            // Status: requested, scheduled, in_progress, completed, cancelled, converted
            $table->string('status')->default('requested');

            // Assignment
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();

            // Diagnostic results
            $table->string('report_path')->nullable(); // PDF report
            $table->text('gaps_identified')->nullable(); // JSON or text summary
            $table->text('recommendations')->nullable();
            $table->enum('overall_gap_level', ['low', 'medium', 'high'])->nullable();

            // Conversion tracking
            $table->foreignId('converted_to_quote_id')->nullable()->constrained('quotes')->nullOnDelete();
            $table->timestamp('converted_at')->nullable();

            // Notes
            $table->text('notes')->nullable();
            $table->text('internal_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('scheduled_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnostic_requests');
    }
};
