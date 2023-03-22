<?php

use Illuminate\Database\Seeder;
use App\bpjs;
use App\potongan;
use App\potongangaji;
use App\pendapatangaji;
use App\pendapatan;
use App\mastergaji;
// use DB;

class gajiseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // umk seed
        mastergaji::create([
        'nomimal'=>'2000000',
        'type'=>'umk',
        'role'=>'all'
        ]);
        pendapatan::create([
            'data'=>'1500000',
            'role'=>'all',
            'type'=>'tunjangan lama berkerja',
        ]);
        pendapatan::create([
            'data'=>'1670000',
            'role'=>'1',
            'type'=>'tunjangan keahlian',
        ]);
        bpjs::create([
            'bpjs_tk'=>'2',
            'bpjs_kes'=>'6',
            'bpjs_ht'=>'3'
        ]);
    }
}
