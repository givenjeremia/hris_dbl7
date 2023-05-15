<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Absensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   
// latlong
// time
// date
// id_user
// lokasi 
// absen masuk
// absen pulang
// status

    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lat_masuk')->nullable(); 
            $table->string('long_masuk')->nullable();
            $table->string('lat_pulang')->nullable(); 
            $table->string('long_pulang')->nullable();
            $table->time('masuk')->nullable($value = true);
            $table->time('pulang')->nullable($value = true);
            $table->date('date');
            $table->string('lokasi_masuk')->nullable();
            $table->string('lokasi_pulang')->nullable();
            $table->string('status')->nullable($value = true);
            $table->string('keterangan')->nullable($value = true);
            // $table->string('id_pegawai')->nullable($value = true);
            // $table->string('id_client')->nullable($value = true);
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
        Schema::dropIfExists('absensi');
    }
}
