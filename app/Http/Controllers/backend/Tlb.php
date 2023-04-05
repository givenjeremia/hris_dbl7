<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\pendapatan;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class Tlb extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.tlb.index');
    }

    public function listdata(){
        return Datatables::of(DB::table('pendapatans')
        ->where('type','tunjangan lama berkerja')
        ->leftjoin('jabatan', function ($join) {
            $join->On('pendapatans.role', '=','jabatan.nama')
            ->orOn('pendapatans.role', '=', 'jabatan.id');
            
        })
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
        $check = pendapatan::where('type','tunjangan lama berkerja')->where('role','all')->value('id');
        $jabatan = DB::table('jabatan')->whereNotIn('nama', ['all'])->orderby('nama','asc')->get();
        return view('backend.tlb.create',compact('jabatan','check'));
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
            'type'=>'tunjangan lama berkerja'
        ]);
        return redirect('/backend/tunjanganlamaberkerja')->with('status','Sukses menyimpan data');
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
        return view('backend.tlb.edit',compact('jabatan','data'));
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
            'type'=>'tunjangan lama berkerja'
        ]);
        return redirect('/backend/tunjanganlamaberkerja')->with('status','Sukses merubah data');
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
