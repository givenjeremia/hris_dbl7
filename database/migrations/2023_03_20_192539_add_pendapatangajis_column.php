<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPendapatangajisColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('potongangajis' , function(Blueprint $table){
            $table->unsignedBigInteger('pendapatangajis_id')->nullable();
            $table->foreign('pendapatangajis_id')->references('id')->on('pendapatangajis');
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
        Schema::table('potongangajis' , function (Blueprint $table){
            $table->dropForeign(['pendapatangajis_id']);
            $table->dropColumn('pendapatangajis_id');
        });

    }
}
