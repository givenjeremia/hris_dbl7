<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientidColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('absensi' , function(Blueprint $table){
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('client');
        });
        Schema::table('pegawai' , function(Blueprint $table){
            $table->unsignedBigInteger('kantor_id')->nullable();
            $table->foreign('kantor_id')->references('id')->on('client');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('absensi' , function (Blueprint $table){
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });

        Schema::table('pegawai' , function (Blueprint $table){
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });

    }
}
