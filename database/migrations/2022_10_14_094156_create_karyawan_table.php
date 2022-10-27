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
            $table->unsignedBigInteger('nip')->nullable();
            $table->string('jabatan')->nullable();
            $table->date('mulai_kerja')->nullable();
            $table->string('tmpt_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('alamat_ktp')->nullable();
            $table->string('alamat_domisili')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('no_hp_darurat')->nullable();
            $table->string('status_pekerja')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->integer('lama_kontrak')->nullable();
            $table->date('habis_kontrak')->nullable();
            $table->bigInteger('gaji')->nullable();
            $table->integer('sisa_cuti')->nullable();
            $table->integer('is_active')->nullable();
            $table->timestamp('tanggal_keluar');
            $table->timestamps();
            $table->softDeletes();
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
