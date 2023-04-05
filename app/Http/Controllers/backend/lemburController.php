<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\lembur;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
class lemburController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.lembur.index');
    }
    public function permohonan(){
        return view('backend.lembur.permohonan');
    }
    public function listdata(){
        $master = DB::table('lemburs as l')
        ->where('status','Diterima')
        ->leftjoin('pegawai as p','l.pegawai_id','=','p.id')
        ->select('l.*','p.nama as nama')
        ->orwhere('status','Ditolak')
        ->get();
        // dd($master);
        return Datatables::of($master)->make(true);
    }
    public function listdataP(){
        return Datatables::of(DB::table('lemburs as l')
        ->where('status','pending')
        ->leftjoin('pegawai as p','l.pegawai_id','=','p.id')
        ->select('l.*','p.nama as nama')
        ->get())->make(true);
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
     * @param  int  $status
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }
    public function actionpermohonan($id,$status){
        $data =lembur::where('id',$id)->value('id');
            if(empty($data)===false){
                if($status == 'diterima'){
                lembur::where('id',$id)->update([
                    'status' => 'Diterima'
                ]);
                return redirect('/backend/lembur')->with('status','Lembur Di Terima');
            }
            elseif($status == 'ditolak'){
                lembur::where('id',$id)->update([
                    'status' => 'Ditolak'
                ]);
                return redirect('/backend/lembur')->with('danger','Lembur Di Tolak');
            }
            else{
                return redirect('/backend/permohonan-lembur')->with('danger','input yang ada masukan salah');
            }
        }
        elseif(empty($data)){
            return redirect('/backend/permohonan-lembur')->with('danger','input yang ada masukan salah');
        }
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
