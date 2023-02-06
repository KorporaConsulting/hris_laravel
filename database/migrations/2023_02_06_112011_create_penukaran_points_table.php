<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenukaranPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penukaran_points', function (Blueprint $table) {
            $table->id();
            $table->integer('pengurangan_point');
            $table->string('reward');
            $table->date('tanggal_penukaran');
            $table->integer('user_id');
            $table->integer('approved_by');
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
        Schema::dropIfExists('penukaran_points');
    }
}
