<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('nip');
            $table->string('jabatan');
            $table->date('mulai_kerja');
            $table->string('tmpt_lahir');
            $table->date('tgl_lahir');
            $table->string('alamat_ktp');
            $table->string('alamat_domisili');
            $table->string('no_hp');
            $table->string('no_hp_darurat');
            $table->string('status_pekerja');
            $table->string('status_perkawinan');
            $table->integer('lama_kontrak');
            $table->date('habis_kontrak');
            $table->bigInteger('gaji');
            $table->integer('sisa_cuti');
            $table->integer('is_active');
            // $table->timestamps('tanggal_keluar');
            $table->timestamp('deleted_at');
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
        Schema::dropIfExists('karyawan');
    }
}
