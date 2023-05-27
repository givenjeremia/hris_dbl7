<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\jabatan;
use App\pegawai;
use App\devisi;
use App\slugJadwal;
use App\Http\Resources\listdata;
use stdClass;
use App\JadwalShift;
use App\newshift;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class JadwalshiftCotroller extends Controller
{
    /**
     * Display a listing of the resource.
     
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years_now = Carbon::now()->year;
        $month_now = Carbon::now()->month;
        $month = $years_now.'-'.$month_now;
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        $date_1_month = [];
        while ($start->lte($end)) {
            $date_1_month[] = $start->copy()->toDateString();
            $start->addDay();
        }
        $data = newshift::all();


        // New
        // Get Count By Divisi
        $data_count_divisi = DB::select( DB::raw('SELECT id,tanggal,COUNT(tanggal) AS count_tanggal FROM `new_jadwal_shifts` WHERE divisi_id IS NOT NULL GROUP BY tanggal;'));
        // Get Count By Pegawai
        $data_count_pegawai = DB::select( DB::raw('SELECT id,tanggal,COUNT(tanggal) AS count_tanggal FROM `new_jadwal_shifts` WHERE pegawai_id IS NOT NULL GROUP BY tanggal;'));
        // $data_type_in_new_shift_by_ids = DB::select( DB::raw('SELECT id,Ids,type,COUNT(tanggal) AS count_tanggal FROM `new_jadwal_shifts` GROUP BY Ids,type ORDER BY Ids'));
       
        foreach($date_1_month as $key => $month){
            $date_1_month[$key] =[];

            array_push($date_1_month[$key],$month);
            $date_1_month[$key][1] = [];
            
            foreach ($data_count_divisi as  $value) {
                if($month == $value->tanggal ) {
                
                // $date_1_month[$key][1] = 
                array_push($date_1_month[$key][1],['count' =>$value->count_tanggal,'type'=>'divisi']);

                }

            }
    
            foreach ($data_count_pegawai as  $value) {
                if($month == $value->tanggal ) {
                    $count_lama = $date_1_month[$key][1];

                    $count_baru = $value->count_tanggal;
                    
                    // $date_1_month[$key][1] = $count_lama + $count_baru;
                    // $date_1_month[$key][1] = ['count' =>$value->count_tanggal,'type'=>'divisi'];
                    array_push($date_1_month[$key][1],['count' =>$value->count_tanggal,'type'=>'pegawai']);
    
                }

            }
            
           

        }
        // dd($date_1_month);
   
        // $data = DB::select( DB::raw('SELECT type FROM `new_jadwal_shifts` GROUP BY type ORDER BY type'));
        $data = ['divisi','pegawai'];

        
        return view('backend.jadwal.index',['data'=>$data ,'date_1_month'=>$date_1_month,'bulan_sekarang'=>Carbon::now()->format('F')]);
    }
    public function listdata(){
        $jabatan = jabatan::all();
        $pegawai = pegawai::select('nama','id')->get();
        $devisi = devisi::all();
        return new listdata(['jabatan'=>$jabatan,'pegawai'=>$pegawai,'devisi'=>$devisi]);
    }



    /**
     * Show the form for creating a new resource.
     * @param  int  $id
     * @param  int  $date
     * @param  int  $type
     * @param  int  $month
     * @param  int  $year
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function AddJadwal( $id,$date,$type){
        $date_start = explode(",",$date)[0];
        $date_end = explode(",",$date)[1];
        $dateRange = CarbonPeriod::create($date_start, $date_end)->toArray();

        // dd($id);
        foreach ($dateRange as $key => $value) {
            # code...
            $date = $value->toDateString();

        }
        $shift = DB::table('shift')->get();
        // $hari_ini = date("Y-$date-d");
        // $tgl_pertama = date("Y-$date-01", strtotime($hari_ini));
        // $tgl_terakhir = date("Y-$date-t", strtotime($hari_ini));
        // for($x = $tgl_pertama; $x <= $tgl_terakhir;$x++){
        // $X[] = $x;
        // }
        // $dates =$X;
    // return view ('backend.jadwal.create',['date'=>$dates,'month'=>$date,'id'=>$id,'type'=>$type,'start'=>$tgl_pertama,'end'=>$tgl_terakhir]);
        return view ('backend.jadwal.create',['shift'=>$shift,'date'=>$dateRange,'id'=>$id,'type'=>$type,'start'=>$date_start,'end'=>$date_end]);
    
    }
    public function Listjadwal(){
        $shift = newshift::all();
        return Datatables::of($shift)->make(true);
    }
    public function slugid($month,$year,$type,$time){
        $slug = slugJadwal::select('id')->where('years',$year)->where('type',$type)->where('timer',$time)->get();
        foreach($slug as $s){
            return response()->json($s);
        }
    }

    public function detailJadwal($type,$tanggal){
        // 'divisi','pegawai'
        $type_id = '';
        if($type == 'divisi'){
            $type_id = 'divisi_id';
        }
        else{
            $type_id = 'pegawai_id';
        }
        $shift = newshift::whereNotNull($type_id)->where('tanggal',$tanggal)->get();
        $title = $type.' -- '.date('d-m-Y', strtotime($tanggal));
        $detail_shift = [];
        foreach ( $shift  as $key => $value) {
            if(empty($value->divisi_id)){
                $types= pegawai::find($value->pegawai_id);
            }
            else{
                $types = devisi::find($value->divisi_id);
            }
            $details = [
                'id_jadwal_shift'=>$value->id,
                'id_shift'=>$value->shift->id,
                'nama_shift'=>$value->shift->nama,
                'id_type'=> $types->id,
                'type_name'=>$types->nama,
                'tanggal' => $value->tanggal,
                'keterangan'=>$value->keterangan,
            ];
            array_push($detail_shift ,$details);
        } 
        // dd($detail_shift);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('backend.jadwal.detail',compact('title','detail_shift'))->render()
        ),200);
        // return Datatables::of($shift)->make(true);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Cek Jika Ada Shift Yang Sudah Di Simpan 
        foreach ($request->get('input') as $value) {
            $divisi_id = $request->get('type') == 'Devisi' ? $request->get('id') : null;
            $pegawai_id = $request->get('type') == 'Pegawai' ? $request->get('id') : null;
            $tanggal = $value['date'];
            $check_divisi  = newshift::where( 'divisi_id' , $divisi_id )->where('tanggal', $tanggal)->get();
            $check_pegawai  = newshift::where( 'pegawai_id' , $pegawai_id )->where('tanggal', $tanggal)->get();
            if(count($check_divisi) > 0 or count($check_pegawai) > 0) {
                return redirect('/backend/jadwal')->with('gagal','Ada Kesalahan Input Shift');
            }


        }
        foreach ($request->get('input') as $value) {
            // dd($request->get('Ids'));
            $new = new newshift();
            // dd($request->get('type'));
            $new->divisi_id = $request->get('type') == 'Devisi' ? $request->get('id') : null;
            $new->pegawai_id = $request->get('type') == 'Pegawai' ? $request->get('id') : null;
            $new->tanggal = $value['date'];
            $new->shift_id = $value['shift'];
            $new->keterangan = $value['keterangan'];
            $new->save();
            


            # code...
        }
        // dd($request->get('input'));
                // $cuti =newshift::insert($request->all()) ;
        return redirect('/backend/jadwal')->with('status','Sukses menambah data');
//    response
            
        
            
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
        newshift::where('id', $id)->delete();
    }
}
