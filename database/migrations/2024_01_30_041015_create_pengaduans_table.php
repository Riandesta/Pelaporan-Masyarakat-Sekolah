<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduansTable extends Migration
{
    public function up()
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->string('foto')->nullable(); // Kolom untuk menyimpan foto
            $table->date('tanggal_diajukan')->default(now()); // Default ke tanggal saat ini
            $table->string('status')->default('pending');
            $table->foreignId('id_jenis_laporan')->constrained('jenis_laporans');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaduans');
    }
}
