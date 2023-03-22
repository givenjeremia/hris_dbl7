<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use DataTables;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.data.pegawai.index');
    }

    public function listdata(){
        return Datatables::of(DB::table('pegawai')
        ->leftjoin('divisi','divisi.id','=','pegawai.divisi_id')
        // ->leftjoin('jabatan','jabatan.id','=','pegawai.id_jabatan')
        ->leftjoin('pendapatans','pendapatans.id','=','pegawai.pendapatans_id')
        ->leftjoin('client','client.id','=','pegawai.kantor_id')
        ->select('pegawai.*','divisi.nama as divisi','pendapatans.data as pendapatan','client.nama as kantor')
        ->get())->make(true);
    }
    public function listdataajax(){
        return Datatables::of(DB::table('pegawai')
        ->crossJoin('new_jadwal_shifts as jd')
        ->leftjoin('divisi','divisi.id','=','pegawai.id_divisi')
        ->leftjoin('jabatan','jabatan.id','=','pegawai.id_jabatan')
        ->leftjoin('client','client.id','=','pegawai.id_kantor')
        ->select('pegawai.*','divisi.nama as divisi','jabatan.nama as jabatan','client.nama as kantor','jd.id as id_shift')
        ->get())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisi = DB::table('divisi')->orderby('nama','asc')->get();
        $jabatan = DB::table('jabatan')->orderby('nama','asc')->get();
        $kantor = DB::table('client')->orderby('nama','asc')->get();
        $pendapatans = DB::table('pendapatans')->get();
        return view('backend.data.pegawai.create', compact('divisi','jabatan','kantor','pendapatans'));
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
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'divisi' => 'required',
            // 'jabatan' => 'required',
            'no_rekening' => 'required',
            'password'=> 'required',
            'email'=>'required'
        ]);
        $tgl_lahir = Carbon::parse($request->tgl_lahir); 
        DB::table('pegawai')->insert([
            'nama' => $request->nama,
            'tgl_lahir' => $tgl_lahir->format('Y-m-d'),
            'alamat' => $request->alamat,
            'divisi_id' => $request->divisi,
            'pendapatans_id' => $request->pendapatan,
            'no_rekening' => $request->no_rekening,
            'kantor_id'=>$request->kantor
        ]);
        $id_pegawai = DB::table('pegawai')->where('nama',$request->nama)->value('id');
        if(empty($id_pegawai)===false){
            $id_pegawai = DB::table('pegawai')->where('nama',$request->nama)->value('id');
        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'level' => 'Pegawai',
            'username' => $request->nama,
            'id_pegawai'=>$id_pegawai,
            'password' => Hash::make($request->password),
        ]);
        }
     
        return redirect('/backend/pegawai')->with('status','Sukses menyimpan data');
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
        $data = DB::table('pegawai')->where('id', $id)->get();
        $divisi = DB::table('divisi')->orderby('nama','asc')->get();
        $jabatan = DB::table('jabatan')->orderby('nama','asc')->get();
        $kantor = DB::table('client')->orderby('nama','asc')->get();
        $pendapatans = DB::table('pendapatans')->get();

        return view('backend.data.pegawai.edit', compact('data','divisi','jabatan','kantor','pendapatans'));
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
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'divisi' => 'required',
            'pendapatan' => 'required',
            'no_rekening' => 'required',
            'kantor'=>'required'
        ]);
        $tgl_lahir = Carbon::parse($request->tgl_lahir);
        DB::table('pegawai')->where('id', $id)->update([
            'nama' => $request->nama,
            'tgl_lahir' => $tgl_lahir->format('Y-m-d'),
            'alamat' => $request->alamat,
            'divisi_id' => $request->divisi,
            'pendapatans_id' => $request->pendapatan,
            'no_rekening' => $request->no_rekening,
            'kantor_id'=>$request->kantor
        ]);
        return redirect('/backend/pegawai')->with('status','Sukses merubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pegawai')->where('id', $id)->delete();
        User::where('id_pegawai',$id)->delete();
    }
}
