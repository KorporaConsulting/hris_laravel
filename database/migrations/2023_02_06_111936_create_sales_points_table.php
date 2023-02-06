<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_points', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi');
            $table->json('files');
            $table->integer('user_id');
            $table->integer('point');
            $table->integer('is_approved')->nullable()->comment('1 untuk approved, 0 untuk tidak approved');
            $table->integer('approved_by')->nullable();
            $table->integer('tanggal_approve')->nullable();
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
        Schema::dropIfExists('sales_points');
    }
}
