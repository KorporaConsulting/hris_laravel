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
            $table->string('jenis_cuti');
            $table->string('lokasi_cuti');
            $table->integer('lama_cuti');
            $table->integer('sisa_cuti');
            $table->integer('awal_cuti');
            $table->date('mulai_tanggal');
            $table->date('sampai_tanggal');
            $table->text('keterangan_cuti');
            $table->string('nama_atasan');
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
