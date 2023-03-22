<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('jadwal_shifts', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('Ids');
        //     $table->date('date')->nullable();
        //     $table->string('shift')->nullable();
        //     $table->string('month')->nullable();
        //     $table->string('keterangan')->nullable();
        //     $table->string('type')->nullable();
        //     $table->string('urut')->nullable();
        //     $table->string('slug');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('jadwal_shifts');
    }
}
