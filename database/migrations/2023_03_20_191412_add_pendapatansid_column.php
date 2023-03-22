<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPendapatansidColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('roles' , function(Blueprint $table){
            $table->unsignedBigInteger('pendapatans_id')->nullable();
            $table->foreign('pendapatans_id')->references('id')->on('pendapatans');
        });

        Schema::table('pegawai' , function(Blueprint $table){
            $table->unsignedBigInteger('pendapatans_id')->nullable();
            $table->foreign('pendapatans_id')->references('id')->on('pendapatans');
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
        Schema::table('roles' , function (Blueprint $table){
            $table->dropForeign(['pendapatans_id']);
            $table->dropColumn('pendapatans_id');
        });

        Schema::table('pegawai' , function (Blueprint $table){
            $table->dropForeign(['pendapatans_id']);
            $table->dropColumn('pendapatans_id');
        });

    }
}
