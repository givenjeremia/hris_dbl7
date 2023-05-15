<?php

namespace App\Http\Controllers\backend;

use App\devisi;
use App\jabatan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisi = devisi::all();
        return view('backend.data.jabatan.index',compact('divisi'));
    }

    public function listdata(){
        $jabatan = jabatan::join('divisi', 'jabatan.divisi_id', '=', 'divisi.id')
                    ->select('jabatan.*', 'divisi.nama as divisi_nama')
                    ->get();
        return Datatables::of($jabatan)->make(true);
    }
    public function listdataajax(){
        return Datatables::of(DB::table('jabatan')
        ->crossJoin('new_jadwal_shifts as jd')
        ->select('jabatan.*','jd.id as id_shift')
        ->get())->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'gaji' => 'required',
            'divisi_id' => 'required'

        ]);
        $check = jabatan::where('nama', $request->nama)->get();
        if(count($check) == 0) {
            DB::table('jabatan')->insert([
                'nama' => $request->nama,
                'nominal_gaji'=>$request->gaji,
                'divisi_id' => $request->divisi_id
            ]);
            return redirect('/backend/jabatan')->with('status','Sukses menyimpan data');
        }
        else{
            return redirect('/backend/jabatan')->with('gagal','Gagal menyimpan data');
        }
       
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
            'gaji' => 'required',
            'divisi_id' => 'required'
        ]);
        $check = jabatan::where('nama', $request->nama)->get();
        if(count($check) == 0) {
            DB::table('jabatan')->where('id', $id)->update([
                'nama' => $request->nama,
                'nominal_gaji'=>$request->gaji,
                'divisi_id' => $request->divisi_id
            ]);
            return redirect('/backend/jabatan')->with('status','Sukses merubah data');
        }
        else{
            return redirect('/backend/jabatan')->with('gagal','Gagal merubah data');
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('jabatan')->where('id', $id)->delete();
    }
    public function getEditForm(Request $request){
        // dd("Masuk");p
        $id = $request->get('id');
        $jabatan = jabatan::find($id);
        $divisi = devisi::all();
        // dd($divisi);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('backend.data.jabatan.edit_modal', compact('jabatan','divisi'))->render()
        ),200);
    }
}
