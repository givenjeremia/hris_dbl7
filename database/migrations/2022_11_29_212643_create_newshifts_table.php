<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewshiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_jadwal_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('Ids');
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            for($x = 1; $x <= 31; $x++){
                $table->string("$x")->nullable();
                }
            $table->string('month')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('new_jadwal_shifts');
    }
}
