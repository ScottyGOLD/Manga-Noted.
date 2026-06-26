<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;   
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Ganti kata 'Subjek' yang di dalam kurung ini menjadi $table
        Schema::table('mangas', function (Blueprint $table) {
            // Menambahkan target chapter dengan nilai default 0
            $table->integer('target_chapter')->default(0)->after('last_read_chapter');
        });
    }

    public function down()
    {
        // Ganti kata 'Subjek' di sini juga menjadi $table
        Schema::table('mangas', function (Blueprint $table) {
            $table->dropColumn('target_chapter');
        });
    }
};
