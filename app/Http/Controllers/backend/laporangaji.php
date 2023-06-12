<?php

namespace App\Http\Controllers\backend;

// use DB;
use App\bpjs;
use App\Absen;
use App\cutis;
use App\devisi;
use App\lembur;
use App\jabatan;
use App\pegawai;
use Carbon\Carbon;
use App\mastergaji;
use App\pendapatan;
use App\potongangaji;
use App\pendapatangaji;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class laporangaji extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = mastergaji::whereNotIn('keterangan',['umk'])->get();
        
        return view('backend.laporangaji.index');
    }

    public function indexAjax()
    {

        $data = pendapatan::all();
        $gaji = new pendapatan();
        $gaji = $gaji->showGaji($data);
        // dd($gaji);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('backend.laporangaji.table',compact('gaji'))->render()
        ), 200);
        // return Datatables::of($data)->make(true);
    }
    public function listdata(){
        $master = DB::table('mastergajis as mg')
        ->leftjoin('pegawai as p', 'mg.role', '=', 'p.id')
        ->leftjoin('pendapatangajis as pg', 'mg.id', '=', 'pg.slug_id')
        ->leftjoin('potongangajis as pgs', 'pg.id', '=', 'pgs.pendapatangajis_id')
        ->select('mg.*',
        'pg.keterangan as nama_pg',
        'pg.nomimal as data_pg',
        'pgs.type as nama_pgs',
        'pgs.data as data_pgs',
        'p.nama as nama_pegawai'
        )
        ->get();
        // dd($master);
        return DataTables::of($master)->make(true);
    }

    
    public function listdatabymonth($month) {
        $params = $month.'%';
        // dd($params);
        $data = pendapatan::whereDate('created_at', 'like',$params)->get();
        $gaji = new pendapatan();
        $gaji = $gaji->showGaji($data);

        return response()->json(array(
            'status' => 'oke',
            'msg' => view('backend.laporangaji.table',compact('gaji'))->render()
        ), 200);
    }

    public function perhitunganGaji(){
        $tanggal_now = Carbon::now();
        // Get Data 
        $pegawai = pegawai::all();
        $divisi = devisi::all();
        
        // Cek Apakah Bulan Ini Sudah Di Generate
        $params = Carbon::now()->year.'-'.Carbon::now()->format('m').'%';
        // Hapus Data Yang Sudah Ada
        $before = pendapatan::whereDate('created_at', 'like',$params)->get();
        if(count($before) != 0){

            foreach ($before as $key => $value) {
                # code...
                $id_gaji = $value->potongangajis_id ;
                $id_bpjs = $value->potonganbpjs_id ;
                $value->delete();
                $p = DB::select(DB::raw('DELETE FROM `potongangajis` WHERE `id` = '.$id_gaji ));
                $p = DB::select(DB::raw('DELETE FROM `potongangajis` WHERE `id` = '.$id_bpjs ));
                // dd($value);
            }
        }
        $data = pendapatan::whereDate('created_at', 'like',$params)->get();
        // dd($params);
        // dd(count($data));
        if(count($data) == 0){
            foreach ($pegawai as $key => $value) {
                // Get Data Pegawai 
                $id_pegawai = $value->id;
                $id_jabatan = $value->jabatan_id;

                // Get UMK 
                $jabatan = jabatan::where('id', $id_jabatan)->first();
                $umk_nominal = $jabatan->nominal_gaji;

                // Set Upah per Hari
                $upah_per_hari = $umk_nominal / 25;

                // Get TK
                $id_divisi = $jabatan->divisi_id;
                $divisi = devisi::where('id', $id_divisi)->first();
                $tk_nominal = $divisi->nominal_tunjangan;

                // Get TLB
                $tanggal_gabung = Carbon::parse($value->created_at);
                $lama_kerja = $tanggal_gabung->diffInMonths($tanggal_now);
                $tlb_nominal = $lama_kerja * 5000;

                // Get Lembur
                $total_jam_lembur = 0;
                $lembur = lembur::whereDate('tanggal', 'like',$params)->get();
                $upah_lembur_per_jam = 1.5 * $umk_nominal * 0.000578;
                foreach ($lembur as $item) {
                    $total_jam_lembur = $total_jam_lembur + $item->lama_lembur;
                }
                $lembur_nominal = $total_jam_lembur * $upah_lembur_per_jam;
                
                
                // Get Potongan BPJS
                $bpjs  = bpjs::all();
                $bpjs_ht = $bpjs[0]->bpjs_ht / 100;
                $bpjs_kes = $bpjs[0]->bpjs_kes / 100;
                $bpjs_tk = $bpjs[0]->bpjs_tk / 100;
                $potongan_bpjs = ($umk_nominal  * $bpjs_ht) + ($umk_nominal  * $bpjs_kes) + ($umk_nominal  * $bpjs_tk);
                
                // Get Potongan Gaji (Absensi)
                $count_terlambat = count(Absen::whereDate('date', 'like',$params)->where('status','Telat')->get());
                $count_masuk = count(Absen::whereDate('date', 'like',$params)->where('status','Tepat Waktu')->get());
                $potongan_absensi = 0;
                if($count_terlambat > 3  || $count_terlambat <= 8 ){
                    $potongan_absensi = $upah_per_hari * 1;
                }
                else if($count_terlambat > 8  || $count_terlambat <= 12){
                    $potongan_absensi = $upah_per_hari * 2;
                }
                else if ($count_terlambat > 12 || $count_terlambat <= 16){
                    $potongan_absensi = $upah_per_hari * 3;
                }
                else if ($count_terlambat > 16 || $count_terlambat <= 20){
                    $potongan_absensi = $upah_per_hari * 4;
                }
                else if ($count_terlambat > 20 || $count_terlambat <= 24){
                    $potongan_absensi = $upah_per_hari * 5;
                }
                else{
                    $potongan_absensi = $upah_per_hari * 6;
                }

                // Get Potongan Gaji (Cutis)
                $jatah_cuti_satu_tahun  = 12;
                $tahun_now = Carbon::now()->year.'%';
                $cutis = cutis::whereDate('mulai','like',$tahun_now)->whereDate('akhir','like',$tahun_now)->where('pegawai_id',$id_pegawai)->get();
                foreach ($cutis as $data){
                    $tanggal_mulai = Carbon::parse($data->mulai);
                    $tanggal_akhir = Carbon::parse($data->akhir);
                    $jatah_cuti_satu_tahun = $jatah_cuti_satu_tahun - $tanggal_mulai->diffInMonths($tanggal_akhir);
                }
                $potongan_cuti = 0;
                if($jatah_cuti_satu_tahun < 0){
                    $potongan_cuti = $upah_per_hari * abs($jatah_cuti_satu_tahun);
                }

                $potongan_gaji = $potongan_absensi + $potongan_cuti;


                // Set Total Gaji Variable
                $total_gaji_bersih = ( $umk_nominal + $tlb_nominal + $tk_nominal + $lembur_nominal ) - ( $potongan_bpjs + $potongan_gaji);
                // dd($total_gaji_bersih);
                // Upload To Database

                // Potongan Gaji
                $potongan_gaji_by_gaji = new potongangaji();
                $potongan_gaji_by_gaji->nominal = $potongan_gaji;
                $potongan_gaji_by_gaji->keterangan = "gaji";
                $potongan_gaji_by_gaji->save();
                $id_potongan_gaji = $potongan_gaji_by_gaji->id;

                // Potongan Gaji BPJS 
                $potongan_gaji_by_bpjs = new potongangaji();
                $potongan_gaji_by_bpjs->nominal = $potongan_bpjs;
                $potongan_gaji_by_bpjs->keterangan = "bpjs";
                $potongan_gaji_by_bpjs->save();
                $id_potongan_bpjs = $potongan_gaji_by_bpjs->id;

                // Pendapatan
                $pendapatan = new pendapatan();
                $pendapatan->nominal = $total_gaji_bersih;
                $pendapatan->nominal_tlb  = $tlb_nominal;
                $pendapatan->nominal_lembur = $lembur_nominal;
                $pendapatan->status = 0;
                $pendapatan->potongangajis_id = $id_potongan_gaji;
                $pendapatan->potonganbpjs_id = $id_potongan_bpjs;
                $pendapatan->pegawai_id = $id_pegawai;
                $pendapatan->save();
            }
            $pendapatan = pendapatan::all();
        $gaji = new pendapatan();
        $gaji = $gaji->showGaji($pendapatan);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('backend.laporangaji.table',compact('gaji'))->render()
        ), 200);


        }
        else{
            // Jika Sudah Di Generate
            return response()->json(array(
                'status' => 'error',
                'msg' => "Gaji Bulan Ini Sudah Di Generate"
            ), 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // hapus pendapatan dan potongan 
        $pendapatan = pendapatangaji::where('slug_id', $id)->get();
        foreach ($pendapatan as $key => $value) {
            # code...
            if($value->keterangan == 'UMK'){
                $p = DB::select(DB::raw('DELETE FROM `potongangajis` WHERE `pendapatangajis_id` = '.$value->id));
            }
        }
        $p = DB::select(DB::raw('DELETE FROM `pendapatangajis` WHERE `slug_id` = '.$id));
        $data = mastergaji::find($id);
        $data->delete();
    }
}
