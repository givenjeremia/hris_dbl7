<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePotongangajisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('potongangajis', function (Blueprint $table) {
            $table->id();
            $table->string('id_user');
            $table->string('data')->nullable();
            $table->string('type')->nullable();
            $table->string('slug_id')->nullable();
            $table->string('pendapatan_id')->nullable();
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
        Schema::dropIfExists('potongangajis');
    }
}
