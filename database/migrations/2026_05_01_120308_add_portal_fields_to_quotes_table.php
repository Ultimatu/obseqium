<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->string('token', 64)->nullable()->unique()->after('reference');
            $table->timestamp('approved_at')->nullable()->after('responded_at');
            $table->string('approval_document')->nullable()->after('pdf_path');
        });
    }

    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn(['token', 'approved_at', 'approval_document']);
        });
    }
};
