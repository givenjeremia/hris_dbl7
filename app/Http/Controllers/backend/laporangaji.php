<?php

namespace App\Http\Controllers\backend;

// use DB;
use Carbon\Carbon;
use App\mastergaji;
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
        $data = mastergaji::whereNotIn('keterangan',['umk'])->get();
        
        return view('backend.laporangaji.index',compact('data'));
    }

    public function indexAjax()
    {
        $data = mastergaji::whereNotIn('keterangan',['umk'])->get();
        // dd($data);
        // dd($data);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('backend.laporangaji.table',compact('data'))->render()
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
        $data = mastergaji::whereDate('created_at', 'like',$params)->whereNotIn('keterangan',['umk'])->get();
        // dd($data);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('backend.laporangaji.table',compact('data'))->render()
        ), 200);
    }

    public function perhitunganGaji(){
        $tanggal_now = Carbon::now();
        // Get Data 
        $pegawai = DB::table('pegpreawai')->get();
        $umk = DB::table('mastergajis')->where('keterangan','umk')->get(); // Role By Jabatan
        $tunjangan_keahlian = DB::table('pendapatans')->where('type','tunjangan keahlian')->get(); // Role By Divisi
        // Cek Apakah Bulan Ini Sudah Di Generate
        $params = Carbon::now()->year.'-'.Carbon::now()->format('m').'%';
        $data = mastergaji::whereDate('created_at', 'like',$params)->whereNotIn('keterangan',['umk'])->get();
        // dd($data);
        if(count($data) == 0){
            foreach ($pegawai as $key => $value) {
                $id_pegawai = $value->id;
                $id_divisi = $value->divisi_id;
                $id_jabatan = $value->jabatan_id;
                $umk_nominal = 0;
                $tk_nominal = 0;
                $tlb_nominal = 0;
                $potongan_gaji = 0;
                // Get UMK
                foreach ($umk as $item) {
                    if($item->role == $id_jabatan){
                        $umk_nominal = $item->nominal;
                    }
                }
                // Get TK
                foreach ($tunjangan_keahlian as $item) {
                    if($item->role == $id_divisi){
                        $tk_nominal  = $item->data;
                    }
                }
                // Get TLB By Month
                $tanggal_gabung = Carbon::parse($value->created_at);
                $lama_kerja = $tanggal_gabung->diffInMonths($tanggal_now);
                $tlb_nominal = $lama_kerja * 5000;
                // Get BPJS
                $bpjs_nominal = ($umk_nominal * 0.01) + ($umk_nominal * 0.01) + ($umk_nominal * 0.01);
                // Potongan Gaji By Absen


                $total_gaji = ($umk_nominal + $tk_nominal + $tlb_nominal)-($bpjs_nominal);
                // Add To Database
                // / To Master Gaji
                $master_gaji_insert = new mastergaji();
                $master_gaji_insert->nominal = $total_gaji;
                $master_gaji_insert->role = $id_pegawai;
                $master_gaji_insert->keterangan = "gaji bersih";
                $master_gaji_insert->save();
                $id_master_gaji_insert = $master_gaji_insert->id;

                // / To Pendapatan
                $pendapatan_gaji_by_tk = new pendapatangaji();
                $pendapatan_gaji_by_tk->nomimal = $tk_nominal;
                $pendapatan_gaji_by_tk->keterangan = "tunjangan keahlian";
                $pendapatan_gaji_by_tk->slug_id = $id_master_gaji_insert;
                $pendapatan_gaji_by_tk->pegawai_id = $id_pegawai;
                $pendapatan_gaji_by_tk->save();

                $pendapatan_gaji_by_tlb = new pendapatangaji();
                $pendapatan_gaji_by_tlb->nomimal= $tlb_nominal;
                $pendapatan_gaji_by_tlb->keterangan = "tunjangan lama berkerja";
                $pendapatan_gaji_by_tlb->slug_id = $id_master_gaji_insert;
                $pendapatan_gaji_by_tlb->pegawai_id = $id_pegawai;
                $pendapatan_gaji_by_tlb->save();

                $pendapatan_gaji_by_umk = new pendapatangaji();
                $pendapatan_gaji_by_umk->nomimal = $umk_nominal;
                $pendapatan_gaji_by_umk->keterangan = "UMK";
                $pendapatan_gaji_by_umk->slug_id = $id_master_gaji_insert;
                $pendapatan_gaji_by_umk->pegawai_id = $id_pegawai;
                $pendapatan_gaji_by_umk->save();
                $id_pendapatan_gaji_by_umk = $pendapatan_gaji_by_umk->id;

                // / To Potongan Gaji
                $potongan_gaji_by_bpjs = new potongangaji();
                $potongan_gaji_by_bpjs->data = $bpjs_nominal;
                $potongan_gaji_by_bpjs->type = "bpjs";
                $potongan_gaji_by_bpjs->pendapatangajis_id =  $id_pendapatan_gaji_by_umk;
                $potongan_gaji_by_bpjs->save();

                $potongan_gaji_by_potongan = new potongangaji();
                $potongan_gaji_by_potongan->data = $potongan_gaji;
                $potongan_gaji_by_potongan->type = "potongan gaji";
                $potongan_gaji_by_potongan->pendapatangajis_id =  $id_pendapatan_gaji_by_umk;
                $potongan_gaji_by_potongan->save();

                // dd($total_gaji);

            }
            $data = mastergaji::whereNotIn('keterangan',['umk'])->get();
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('backend.laporangaji.table',compact('data'))->render()
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
    }
}
