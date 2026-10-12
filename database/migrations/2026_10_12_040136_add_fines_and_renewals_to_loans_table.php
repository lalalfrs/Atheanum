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
        Schema::table('loans', function (Blueprint $table) {
            $table->unsignedInteger('fine_amount')->default(0)->after('status');
            $table->boolean('fine_paid')->default(false)->after('fine_amount');
            $table->date('fine_paid_at')->nullable()->after('fine_paid');
            $table->unsignedTinyInteger('renewed_count')->default(0)->after('fine_paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['fine_amount', 'fine_paid', 'fine_paid_at', 'renewed_count']);
        });
    }
};
