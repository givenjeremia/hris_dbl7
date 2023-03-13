<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\cutis;
use DB;
use DataTables;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view ('backend.cuti.index');
    }
    public function listdata(){
        return Datatables::of(DB::table('cutis')->where('status','Diterima')
        ->orwhere('status','Ditolak')
        ->get())->make(true);
    }
    public function listdataP(){
        return Datatables::of(DB::table('cutis')->where('status','pending')->get())->make(true);
    }
    
    public function phcuti()
    {
        return view ('backend.cuti.permohonan');
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        cutis::where('id',$id)->update([
            'status' => 'Diterima'
        ]);
        return redirect('/backend/cuti')->with('status','Cuti Di Terima');
    }
    public function tolak($id){
        cutis::where('id',$id)->update([
            'status' => 'Ditolak'
        ]);
        return redirect('/backend/cuti')->with('danger','Cuti Di Tolak');
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       cutis::where('id',$id)->delete();
    }
}
