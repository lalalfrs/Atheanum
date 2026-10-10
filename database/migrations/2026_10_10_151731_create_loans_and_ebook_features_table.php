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
        Schema::table('books', function (Blueprint $table) {
            $table->boolean('is_ebook')->default(true)->after('status');
            $table->unsignedInteger('ebook_pages')->default(150)->after('is_ebook');
            $table->text('ebook_content')->nullable()->after('ebook_pages');
        });

        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->date('borrowed_at');
            $table->date('due_date');
            $table->date('returned_at')->nullable();
            $table->string('status', 30)->default('dipinjam')->index();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');

        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['is_ebook', 'ebook_pages', 'ebook_content']);
        });
    }
};
