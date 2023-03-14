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

        // // dd($dates);
        // $datas= DB::table('new_jadwal_shifts as sh')
        // ->get();



        $data = newshift::all();
        $data_type_in_new_shift = DB::select( DB::raw('SELECT type FROM `new_jadwal_shifts` GROUP BY type'));

        // New
        $data_type_in_new_shift_by_ids = DB::select( DB::raw('SELECT id,Ids,type,COUNT(tanggal) AS count_tanggal FROM `new_jadwal_shifts` GROUP BY Ids,type ORDER BY Ids'));
        $by_ids = [];
        foreach($date_1_month as $key => $month){
            $date_1_month[$key] =[];
            $date_1_month[$key][0] = $month;
            foreach ($data_type_in_new_shift_by_ids  as  $value) {
                
                foreach($data as  $shift){
                    if($month == $shift->tanggal && $value->type == $shift->type && $value->Ids == $shift->Ids  ) {

                        $detail[$shift->tanggal][$shift->id]= [
                            'ids'=>$shift->Ids,
                            'type'=> $shift->type ,
                            'tanggal'=>$shift->tanggal,
                        ];
                        $date_1_month[$key][1] = $detail[$shift->tanggal];
                    }
                    
                }

            }
           

        }
        // dd(count($date_1_month[12]));
        // dd($by_ids);
        // gabung
        // dd($data_type_in_new_shift);
        $jadwal_shift = [];
        $jadwal_shift['Devisi']=[];
        $jadwal_shift['Jabatan']=[];
        $jadwal_shift['Pegawai']=[];
        // foreach ($data_type_in_new_shift as $value) {
        //     # code...
            foreach ($data as $shift) {
                # code...
                
                // if($value->type == $shift->type){
                    // echo $shift->type;
                    if($shift->type == "Devisi"){
                        $devisi = devisi::find($shift->Ids);
                
                        $detail = [
                            'id' => $devisi->id,
                            'nama'=> $devisi->nama,
                            'tanggal'=>$shift->tanggal,
                            'keterangan'=>$shift->keterangan,
                        ];
                        // dd($detail);

                        array_push( $jadwal_shift['Devisi'] ,$detail);
                        
                    }
                    elseif($shift->type == "Jabatan"){
                        $jabatan = jabatan::find($shift->Ids);
                        $detail[$shift->id] = [
                            'id' => $jabatan->id,
                            'nama'=> $jabatan->nama,
                            'tanggal'=>$shift->tanggal,
                            'keterangan'=>$shift->keterangan,
                        ];
                        array_push( $jadwal_shift['Jabatan'] ,$detail[$shift->id]);
                    }
                    else{
                        $pegawai = pegawai::find($shift->Ids);
                        $detail[$shift->id] = [
                            'id' => $pegawai->id,
                            'nama'=> $pegawai->nama,
                            'tanggal'=>$shift->tanggal,
                            'keterangan'=>$shift->keterangan,
                        ];
                        array_push( $jadwal_shift['Pegawai'],$detail[$shift->id]);

                    }
                // }
            }
        // }
        // dd($jadwal_shift);
        $data = DB::select( DB::raw('SELECT type FROM `new_jadwal_shifts` GROUP BY type ORDER BY type'));

        
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
        $shift = newshift::where('type',$type)->where('tanggal',$tanggal)->get();
        $title = $type.' -- '.date('d-m-Y', strtotime($tanggal));
        $detail_shift = [];
        foreach ( $shift  as $key => $value) {
            if($value->type == "Devisi"){
               $types = devisi::find($value->Ids);
            }
            elseif($value->type == "Jabatan"){
                $types = jabatan::find($value->Ids);
            }
            else{
                $types= pegawai::find($value->Ids);
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
        foreach ($request->get('input') as $value) {
            // dd($request->get('Ids'));
            $new = new newshift();
            $new->Ids = $request->get('Ids');
            $new->type = $request->get('type');
            $new->tanggal = $value['date'];
            $new->shift_id = $value['shift'];
            $new->keterangan = $value['keterangan'];
            $new->save();


            # code...
        }
        // dd($request->get('input'));
                // $cuti =newshift::insert($request->all()) ;
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
