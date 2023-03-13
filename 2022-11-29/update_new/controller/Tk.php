<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\pendapatan;
class Tk extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.tk.index');
    }
    public function listdata(){
        return Datatables::of(DB::table('pendapatans')
        ->where('type','tunjangan keahlian')
        ->join('jabatan', 'pendapatans.role', '=', 'jabatan.id')
        ->select('pendapatans.*','jabatan.nama as nama')
        ->get())->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jabatan = DB::table('jabatan')->whereNotIn('nama', ['all'])->orderby('nama','asc')->get();
        return view('backend.tk.create',compact('jabatan'));
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
        pendapatan::create([
            'data'=>$request->jumlah,
            'role'=>$request->role,
            'type'=>'tunjangan keahlian'
        ]);
        return redirect('/backend/tunjangankeahlian')->with('status','Sukses menyimpan data');
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
        $jabatan = DB::table('jabatan')->whereNotIn('nama', ['all'])->orderby('nama','asc')->get();
        $data = pendapatan::where('id',$id)->get();
        return view('backend.tk.edit',compact('jabatan','data'));
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
        pendapatan::where('id', $id)->update([
            'data'=>$request->jumlah,
            'role'=>$request->role,
            'type'=>'tunjangan keahlian'
        ]);
        return redirect('/backend/tunjangankeahlian')->with('status','Sukses merubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        pendapatan::where('id', $id)->delete();
    }
}
