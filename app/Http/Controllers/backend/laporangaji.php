<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\mastergaji;
class laporangaji extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = mastergaji::whereNotIn('keterangan',['umk'])->get();
        // dd($data);
        return view('backend.laporangaji.index',compact('data'));
    }
    public function listdata(){
        $master = DB::table('mastergajis as mg')
        ->leftjoin('pegawai as p', 'mg.role', '=', 'p.id')
        ->leftjoin('pendapatangajis as pg', 'mg.id', '=', 'pg.slug_id')
        ->leftjoin('potongangajis as pgs', 'pg.id', '=', 'pgs.pendapatangajis_id')
        ->select('mg.*',
        'pg.keterangan as nama_pg',
        'pg.nomimal as data_pg',
        'pgs.type as nama_pgs',
        'pgs.data as data_pgs',
        'p.nama as nama_pegawai'
        )
        ->get();
        // dd($master);
        return Datatables::of($master)->make(true);
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
        //
    }
}
