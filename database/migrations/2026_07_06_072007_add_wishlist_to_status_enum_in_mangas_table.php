<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Menggunakan query native SQL untuk memodifikasi ENUM agar aman di MySQL
        DB::statement("ALTER TABLE mangas MODIFY COLUMN status ENUM('Backlog', 'Reading', 'Completed', 'Wishlist') NOT NULL");
    }

    public function down(): void
    {
        // Mengembalikan ke struktur semula jika di-rollback
        DB::statement("ALTER TABLE mangas MODIFY COLUMN status ENUM('Backlog', 'Reading', 'Completed') NOT NULL");
    }
};