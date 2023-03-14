<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPegawaiidColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // Schema::table('new_jadwal_shifts' , function(Blueprint $table){
        //     $table->unsignedBigInteger('pegawai_id');
        //     $table->foreign('pegawai_id')->references('id')->on('pegawai');
        // });
        Schema::table('lemburs' , function(Blueprint $table){
            $table->unsignedBigInteger('pegawai_id');
            $table->foreign('pegawai_id')->references('id')->on('pegawai');
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
        // Schema::table('new_jadwal_shifts' , function (Blueprint $table){
        //     $table->dropForeign(['pegawai_id']);
        //     $table->dropColumn('pegawai_id');
        // });
        Schema::table('lemburs' , function (Blueprint $table){
            $table->dropForeign(['pegawai_id']);
            $table->dropColumn('pegawai_id');
        });
    }
}
