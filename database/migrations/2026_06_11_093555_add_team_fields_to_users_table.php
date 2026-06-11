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
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('job_title');
            $table->string('photo')->nullable()->after('bio');
            $table->string('linkedin_url')->nullable()->after('photo');
            $table->integer('order')->default(0)->after('linkedin_url');
            // $table->dropColumn('company');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bio', 'photo', 'linkedin_url', 'order']);
            $table->string('company')->nullable()->after('phone');
        });
    }
};
