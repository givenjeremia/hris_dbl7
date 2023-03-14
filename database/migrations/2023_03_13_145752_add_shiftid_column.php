<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShiftidColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('new_jadwal_shifts' , function(Blueprint $table){
            $table->unsignedBigInteger('shift_id');
            $table->foreign('shift_id')->references('id')->on('shift');
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
        Schema::table('new_jadwal_shifts' , function (Blueprint $table){
            $table->dropForeign(['shift_id']);
            $table->dropColumn('shift_id');
        });
    }
}
