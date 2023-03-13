<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Terlambat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('terlambat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_pegawai');
            $table->date('date');
            $table->bigInteger('masuk');
            $table->bigInteger('pulang');
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
        Schema::dropIfExists('terlambat');
    }
}
