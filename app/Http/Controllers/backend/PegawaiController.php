<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
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
        ->leftjoin('jabatan','jabatan.id','=','pegawai.jabatan_id')
        ->leftjoin('client','client.id','=','pegawai.kantor_id')
        ->select('pegawai.*','jabatan.nama as jabatan','client.nama as kantor')
        ->get())->make(true);
    }
    public function listdataajax(){
        return Datatables::of(DB::table('pegawai')
        ->crossJoin('new_jadwal_shifts as jd')
        ->leftjoin('jabatan','jabatan.id','=','pegawai.jabatan_id')
        ->leftjoin('client','client.id','=','pegawai.kantor_id')
        ->select('pegawai.*','jabatan.nama as jabatan','client.nama as kantor','jd.id as id_shift')
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
        $jabatans = DB::table('jabatan')->get();
        return view('backend.data.pegawai.create', compact('divisi','jabatan','kantor','pendapatans','jabatans'));
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
            'jabatan' => 'required',
            'no_rekening' => 'required',
            'password'=> 'required',
            'email'=>'required'
        ]);
        $currentTime = Carbon::now()->timezone('Asia/Jakarta');
        $tgl_lahir = Carbon::parse($request->tgl_lahir); 
        DB::table('pegawai')->insert([
            'nama' => $request->nama,
            'tgl_lahir' => $tgl_lahir->format('Y-m-d'),
            'alamat' => $request->alamat,
            'jabatan_id' => $request->jabatan,
            'no_rekening' => $request->no_rekening,
            'kantor_id'=>$request->kantor,
            'roles_id'=>3,
            'created_at' => $currentTime

        ]);
        $id_pegawai = DB::table('pegawai')->where('nama',$request->nama)->value('id');
        if(empty($id_pegawai)===false){
            $id_pegawai = DB::table('pegawai')->where('nama',$request->nama)->value('id');
        User::create([
            'name' => $request->nama,
            'email' => $request->email,
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
        $jabatans = DB::table('jabatan')->get();

        return view('backend.data.pegawai.edit', compact('data','divisi','jabatan','kantor','pendapatans','jabatans'));
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
            'jabatan' => 'required',
            'no_rekening' => 'required',
            'kantor'=>'required'
        ]);
        $tgl_lahir = Carbon::parse($request->tgl_lahir);
        $currentTime = Carbon::now()->timezone('Asia/Jakarta');
        DB::table('pegawai')->where('id', $id)->update([
            'nama' => $request->nama,
            'tgl_lahir' => $tgl_lahir->format('Y-m-d'),
            'alamat' => $request->alamat,
            'jabatan_id' => $request->jabatan,
            'no_rekening' => $request->no_rekening,
            'kantor_id'=>$request->kantor,
            'updated_at'=>$currentTime
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
