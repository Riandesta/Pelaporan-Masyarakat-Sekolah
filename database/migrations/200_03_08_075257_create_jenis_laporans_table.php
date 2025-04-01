<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisLaporansTable extends Migration
{
    public function up()
    {Schema::create('jenis_laporans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_jenis_laporan')->unique();
        $table->string('handler_role'); // Role yang bertanggung jawab (walikelas/kakomli/kurikulum/wakasek)
        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_laporans');
    }
}
