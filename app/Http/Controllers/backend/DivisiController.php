<?php

namespace App\Http\Controllers\backend;

use App\devisi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.data.divisi.index');
    }

    public function listdata(){
        return DataTables::of(DB::table('divisi')->get())->make(true);
    }
    public function listdataajax(){
        $data= DB::table('divisi')
        ->crossJoin('new_jadwal_shifts as jd')
        ->select('divisi.*','jd.id as id_shift')
        ->get();
        return Datatables::of(DB::table('divisi')
        ->crossJoin('new_jadwal_shifts as jd')
        ->select('divisi.*','jd.id as id_shift')
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
            'tunjangan' => 'required'
        ]);
        $check = devisi::where('nama', $request->nama)->get();
        if(count($check) == 0){
            DB::table('divisi')->insert([
                'nama' => $request->nama,
                'nominal_tunjangan' => $request->tunjangan

            ]);
            return redirect('/backend/divisi')->with('status','Sukses menyimpan data');
        }
        else{
            return redirect('/backend/divisi')->with('gagal','Gagal menyimpan data');
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
            'tunjangan' => 'required',
        ]);
        $check = devisi::where('nama', $request->nama)->get();
        if(count($check) == 0){
            DB::table('divisi')->where('id', $id)->update([
                'nama' => $request->nama,
                'nominal_tunjangan' => $request->tunjangan

            ]);
            return redirect('/backend/divisi')->with('status','Sukses merubah data');;
        }
        else{
            return redirect('/backend/divisi')->with('gagal','Gagal merubah data');
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
        DB::table('divisi')->where('id', $id)->delete();
    }

    public function getEditForm(Request $request){
        // dd("Masuk");
        $id = $request->get('id');
        $divisi = devisi::find($id);

        // dd($divisi);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('backend.data.divisi.edit_modal', compact('divisi'))->render()
        ),200);
    }
}
