<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMastergajisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('mastergajis', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('nominal')->nullable();;
        //     $table->longtext('keterangan')->nullable();
        //     $table->string('role')->nullable();
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
        // Schema::dropIfExists('mastergajis');
    }
}
