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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('isbn', 50)->unique();
            $table->string('author');
            $table->string('publisher');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('category', 100)->index();
            $table->unsignedSmallInteger('year');
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('total_copies')->default(1);
            $table->string('shelf_location', 50);
            $table->enum('status', ['Tersedia', 'Stok Kritis', 'Habis'])->default('Tersedia')->index();
            $table->text('cover_image')->nullable();
            $table->string('image_storage_path')->nullable();
            $table->unsignedInteger('file_size_kb')->nullable()->default(50);
            $table->text('description')->nullable();
            $table->timestamps();

            // Composite index for fast catalog searches
            $table->index(['title', 'author', 'isbn']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
