<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\mastergaji;
use DataTables;
use DB;
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
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Updateprofiles;
use App\Http\Requests\ListCuti;
use PDF;
class umkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.umk.index');
    }
    public function listdata(){
        return Datatables::of(DB::table('mastergajis')->where('keterangan','umk')
        ->leftjoin('jabatan', function ($join) {
            $join->On('mastergajis.role', '=','jabatan.nama')
            ->orOn('mastergajis.role', '=', 'jabatan.id');
            
        })
        ->select('mastergajis.*','jabatan.nama as role')
        ->get())->make(true);
    }
    public function cetakslipgaji(Request $request){
        $id_user = pendapatangaji::where('slug_id',$request->id)->value('id_user');
        $nama = pegawai::where('id',$id_user)->value('nama');
        $id_jabatan = pegawai::where('id',$id_user)->value('id_jabatan');
        $jabatan = jabatan::where('id',$id_jabatan)->value('nama');
        $id_divisi = pegawai::where('id',$id_user)->value('id_divisi');
        $divisi = DB::table('divisi')->where('id',$id_divisi)->value('nama');
        $data_pendapatan = pendapatangaji::where('slug_id',$request->id)->get();
        $data_potongan = potongangaji::where('slug_id',$request->id)->get();
        $totalgaji = mastergaji::where('id',$request->id)->value('data');
        // $pdf = Pdf::loadView('slipgaji_pdf', ['name' => 'James']);
        $pdf = Pdf::loadView('slipgaji_pdf', [
            'name' => $nama,
            'pendapatan'=>$data_pendapatan,
            'potongan'=>$data_potongan,
            'jabatan'=>$jabatan,
            'divisi'=>$divisi,
            'totalgaji'=>$totalgaji
        ]);
        return $pdf->download("laporan-pegawai-slipgaji $nama jabatan:$jabatan");
        return response()->json([
            'message' =>'succes download data',
            
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $check = mastergaji::where('keterangan','umk')->where('role','all')->value('id');
        $jabatan = DB::table('jabatan')->whereNotIn('nama', ['all'])->orderby('nama','asc')->get();
        return view('backend.umk.create',compact('jabatan','check'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required',
            'role' => 'required',
        ]);
        mastergaji::create([
            'nominal'=>$request->jumlah,
            'role'=>$request->role,
            'keterangan'=>'umk'
        ]);
        return redirect('/backend/umk')->with('status','Sukses menyimpan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $check = mastergaji::where('type','umk')->where('role','all')->value('id');
        $jabatan = DB::table('jabatan')->whereNotIn('nama', ['all'])->orderby('nama','asc')->get();
        $data = mastergaji::where('id',$id)->get();
        return view('backend.umk.edit',compact('jabatan','check','data'));
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
        $request->validate([
            'jumlah' => 'required',
            'role' => 'required',
        ]);
        mastergaji::where('id', $id)->update([
            'data'=>$request->jumlah,
            'role'=>$request->role,
            'type'=>'umk'
        ]);
        return redirect('/backend/umk')->with('status','Sukses merubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('mastergajis')->where('id', $id)->delete();
    }
}
