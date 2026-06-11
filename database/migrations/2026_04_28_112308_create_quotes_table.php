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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['draft', 'sent', 'viewed', 'accepted', 'refused', 'revision_requested'])->default('draft');
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone', 20)->nullable();
            $table->string('client_company')->nullable();
            $table->string('client_job_title')->nullable();
            $table->enum('service_type', ['strategic', 'audit', 'qhse', 'training', 'other'])->default('qhse');
            $table->string('sector')->nullable();
            $table->string('company_size')->nullable();
            $table->date('deadline')->nullable();
            $table->text('description')->nullable();
            $table->text('attachments')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(20);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->date('valid_until')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
