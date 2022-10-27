<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCutiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuti', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('jenis_cuti')->nullable();
            $table->string('lokasi_cuti')->nullable();
            $table->integer('lama_cuti')->nullable();
            $table->integer('sisa_cuti')->nullable();
            $table->integer('cuti_awal')->nullable();
            $table->date('mulai_tanggal')->nullable();
            $table->date('sampai_tanggal')->nullable();
            $table->text('keterangan_cuti')->nullable();
            $table->string('nama_atasan')->nullable();
            $table->text('keterangan_atasan')->nullable();
            $table->enum('status', ['waiting', 'reject', 'accept']);
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
        Schema::dropIfExists('cuti');
    }
}
