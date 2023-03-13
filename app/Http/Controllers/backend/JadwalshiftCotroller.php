<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\jabatan;
use App\pegawai;
use App\devisi;
use App\slugJadwal;
use App\Http\Resources\listdata;
use DataTables;
use stdClass;
use App\JadwalShift;
use App\newshift;
use DB;
class JadwalshiftCotroller extends Controller
{
    /**
     * Display a listing of the resource.
     
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas= DB::table('new_jadwal_shifts as sh')
        ->get();
        $data = newshift::all();
        return view('backend.jadwal.index',['data'=>$data]);
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
        $shift = DB::table('shift')->get();
        $hari_ini = date("Y-$date-d");
        $tgl_pertama = date("Y-$date-01", strtotime($hari_ini));
        $tgl_terakhir = date("Y-$date-t", strtotime($hari_ini));
        for($x = $tgl_pertama; $x <= $tgl_terakhir;$x++){
        $X[] = $x;
        }
        $dates =$X;
    return view ('backend.jadwal.create',['date'=>$dates,'shift'=>$shift,'month'=>$date,'id'=>$id,'type'=>$type,'start'=>$tgl_pertama,'end'=>$tgl_terakhir]);
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
                $cuti =newshift::insert($request->all()) ;
                return redirect('/backend/jadwal')->with('status','Sukses merubah data');
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
