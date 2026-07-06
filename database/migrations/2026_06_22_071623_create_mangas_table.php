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
    Schema::create('mangas', function (Blueprint $table) {
        $table->id(); // Ini ID Utamanya Manga (Primary Key)
        $table->string('title');
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        $table->foreignId('author_id')->nullable()->constrained('authors')->onDelete('set null');
        $table->integer('volumes_owned')->default(0);
        $table->integer('last_read_chapter')->default(0);
        $table->enum('status', ['Backlog', 'Reading', 'Completed', 'Wishlist'])->default('Backlog');
        $table->string('cover_image')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mangas');
    }
};
