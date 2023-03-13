<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\jabatan;
use App\User;
use App\pegawai;
use App\Absen;
use App\cutis;
use App\bpjs;
use App\potongan;
use App\potongangaji;
use App\pendapatangaji;
use App\pendapatan;
use App\mastergaji;
use App\JadwalShift;
use App\newshift;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\Updateprofiles;
use App\Http\Requests\ListCuti;
use PDF;
class created_gaji extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gaji:created';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto created gaji';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bulan_ini = date("m");
        $hari_ini = date("Y-m-d");
        $tgl_pertama = date("Y-m-01", strtotime($hari_ini));
        $tgl_terakhir = date("Y-m-t", strtotime($hari_ini));
        $pegawai=pegawai::all();
        foreach($pegawai as $p){
            $id_user = $p->id;
            $id_pegawai = pegawai::where('id',$id_user)->value('id_jabatan');
            $nama_pegawai = pegawai::where('id',$id_user)->value('nama');
            $umk_all = mastergaji::where('role',$id_pegawai)->where('type','umk')->value('data');
            $l_berkerja = User::where('id_pegawai',$id_user)->value('created_at');
            $lama_berkerja = date_diff( date_create($l_berkerja), date_create() );
            $master_lama_berkerja = pendapatan::where('type','tunjangan lama berkerja')->where('role',$id_pegawai)->value('data');
            if(empty($master_lama_berkerja) === true){
                $master_lama_berkerja = pendapatan::where('type','tunjangan lama berkerja')->where('role','all')->value('data');
            }
            $keahlian = pendapatan::where('role',$id_pegawai)->where('type','tunjangan keahlian')->value('data');
            $bonus_lama = $lama_berkerja->m*$master_lama_berkerja;
            $waktu_kerja_all = newshift::whereMonth('month', $bulan_ini)->where('Ids',$id_user)->get()->count();
            $waktu_kerja_libur = newshift::where('shift','libur')->where('Ids',$id_user)->get()->count();
            $waktu_kerja = $waktu_kerja_all-$waktu_kerja_libur;
            $jumlah_cuti = cutis::where('nama',$nama_pegawai)->where('status','diterima')->whereMonth('created_at',$bulan_ini)->get()->count();
            $jumlah_masuk =Absen::whereNotNull('masuk')->whereNotNull('pulang')->whereMonth('date',$bulan_ini)->where('id_pegawai',$id_user)->get()->count();
            if(empty($umk_all) === true){
                $umk = mastergaji::where('role','all')->where('type','umk')->value('data');
                $gaji_kotor = $umk+$bonus_lama+$keahlian;
                $bpjs_tk  = bpjs::value('bpjs_tk');
                $bpjs_kes = bpjs::value('bpjs_kes');
                $bpjs_ht  = bpjs::value('bpjs_ht');
                $bpjs = $bpjs_ht+$bpjs_kes+$bpjs_tk * $umk  / 100; 
                $jumlah_ijin = $waktu_kerja-$jumlah_masuk;
                $Pijin= 0;
                if($jumlah_ijin >= 1){$Pijin =ceil($jumlah_ijin / $waktu_kerja *$umk ) ;}
                $gaji_bersih = $gaji_kotor - $bpjs - $Pijin ;
                mastergaji::create([
                    'role'=>$id_user,
                    'data'=>$gaji_bersih,
                    'type'=>'gaji bersih',
                    'created_at'=>time(),
                ]);
                $id_gaji= mastergaji::whereDate('created_at',$hari_ini)->where('role',$id_user)->value('id');
                if(empty($id_gaji) === false){
                    pendapatangaji::create([
                        'id_user'=>$id_user,
                        'data'=>$umk,
                        'type'=>'umk',
                        'slug_id'=>$id_gaji,
                        'created_at'=>time(),
                    ]);
                    $id_pendapatan= pendapatangaji::whereDate('created_at',$hari_ini)->where('id_user',$id_user)->value('id');
                    potongangaji::create([
                    'id_user'=>$id_user,
                    'data'=> $bpjs,
                    'type'=> 'bpjs',
                    'created_at'=>time(),
                    'slug_id'=>$id_gaji,
                    'pendapatan_id'=>$id_pendapatan
                    ]);
                    pendapatangaji::create([
                        'id_user'=>$id_user,
                        'data'=>$keahlian,
                        'type'=>'tunjangan keahlian',
                        'created_at'=>time(),
                        'slug_id'=>$id_gaji,
                    ]);
                    pendapatangaji::create([
                        'id_user'=>$id_user,
                        'data'=>$bonus_lama,
                        'type'=>'tunjangan lama berkerja',
                        'created_at'=>time(),
                        'slug_id'=>$id_gaji,
                    ]);
                    $id_pendapatan= pendapatangaji::whereDate('created_at',$hari_ini)->where('id_user',$id_user)->value('id');
                    potongangaji::create([
                        'id_user'=>$id_user,
                        'data'=> $Pijin,
                        'type'=> 'potongan gaji',
                        'created_at'=>time(),
                        'slug_id'=>$id_gaji,
                        'pendapatan_id'=>$id_pendapatan+1
                        ]);
                }         
                elseif(empty($id_gaji) === true){
                    return response()->json(['error','server not send database'], 500);
                }        
            }
            elseif(empty($umk_all) === false){
                $umk = mastergaji::where('role',$id_pegawai)->where('type','umk')->value('data');
                $gaji_kotor = $umk+$bonus_lama+$keahlian;
                $bpjs_tk  = bpjs::value('bpjs_tk');
                $bpjs_kes = bpjs::value('bpjs_kes');
                $bpjs_ht  = bpjs::value('bpjs_ht');
                $bpjs = $bpjs_ht+$bpjs_kes+$bpjs_tk * $umk  / 100; 
                $jumlah_ijin = $waktu_kerja-$jumlah_masuk;
                // if($jumlah_ijin >= 1){
                //     $pijin =ceil($jumlah_ijin / $waktu_kerja *$umk ) ;
                //     return $pijin;
                // }
                // else{
                //     $pijin = null;
                // }
                $Pijin=$jumlah_ijin ;
                $gaji_bersih = $gaji_kotor - $bpjs - $Pijin ;
                mastergaji::create([
                    'role'=>$id_user,
                    'data'=>$gaji_bersih,
                    'type'=>'gaji bersih',
                    'created_at'=>time(),
                ]);
                $id_gaji= mastergaji::whereDate('created_at',$hari_ini)->where('role',$id_user)->value('id');
                if(empty($id_gaji) === false){
                    pendapatangaji::create([
                        'id_user'=>$id_user,
                        'data'=>$umk,
                        'type'=>'umk',
                        'slug_id'=>$id_gaji,
                        'created_at'=>time(),
                    ]);
                    $id_pendapatan= pendapatangaji::whereDate('created_at',$hari_ini)->where('id_user',$id_user)->value('id');
                    potongangaji::create([
                    'id_user'=>$id_user,
                    'data'=> $bpjs,
                    'type'=> 'bpjs',
                    'created_at'=>time(),
                    'slug_id'=>$id_gaji,
                    'pendapatan_id'=>$id_pendapatan
                    ]);
                    pendapatangaji::create([
                        'id_user'=>$id_user,
                        'data'=>$keahlian,
                        'type'=>'tunjangan keahlian',
                        'created_at'=>time(),
                        'slug_id'=>$id_gaji,
                    ]);
                    pendapatangaji::create([
                        'id_user'=>$id_user,
                        'data'=>$bonus_lama,
                        'type'=>'tunjangan lama berkerja',
                        'created_at'=>time(),
                        'slug_id'=>$id_gaji,
                    ]);
                    $id_pendapatan= pendapatangaji::whereDate('created_at',$hari_ini)->where('id_user',$id_user)->value('id');
                    potongangaji::create([
                        'id_user'=>$id_user,
                        'data'=> $Pijin,
                        'type'=> 'potongan gaji',
                        'created_at'=>time(),
                        'slug_id'=>$id_gaji,
                        'pendapatan_id'=>$id_pendapatan+1
                        ]);
                }         
                elseif(empty($id_gaji) === true){
                    return response()->json(['error','server not send database'], 500);
                } 
            } 
        }
    }
}



