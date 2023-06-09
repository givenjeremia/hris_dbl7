<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Shift extends Migration
{
    public function up()
    {
        Schema::create('shift', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jam_masuk');
            $table->string('jam_pulang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shift');
    }
}
