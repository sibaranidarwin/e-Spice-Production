<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->bigIncrements('pegawai_id');
            $table->string('nama_pegawai');
            $table->integer('nik');
            $table->string('email');
            $table->string('telepon');
            $table->string('username');
            $table->string('password');
            $table->boolean('flag_active');
            $table->string('bagian');
            $table->boolean('minta_reset');
            $table->string('tgl_minta');
            $table->string('keterangan_reset');
            $table->string('upload_ttd');
            $table->string('staff_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
}
