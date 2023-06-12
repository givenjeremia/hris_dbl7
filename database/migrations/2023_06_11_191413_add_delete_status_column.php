<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // Pegawai
        Schema::table('pegawai' , function(Blueprint $table){
            $table->tinyInteger('delete_at')->unsigned()->default(0);
        });
        // Divisi
        Schema::table('divisi' , function(Blueprint $table){
            $table->tinyInteger('delete_at')->unsigned()->default(0);
        });
        // Jabatan
        Schema::table('jabatan' , function(Blueprint $table){
            $table->tinyInteger('delete_at')->unsigned()->default(0);
        });
        // Shift
        Schema::table('shift' , function(Blueprint $table){
            $table->tinyInteger('delete_at')->unsigned()->default(0);
        });
        // Client
        Schema::table('client' , function(Blueprint $table){
            $table->tinyInteger('delete_at')->unsigned()->default(0);
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
    }
}
