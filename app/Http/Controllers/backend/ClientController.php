<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.client.index');
    }
    public function listdata(){
        return Datatables::of(DB::table('client')->get())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('backend.client.create');
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
            'kontrak' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'lokasi' => 'required',
            'lat' => 'required',
            'long'=> 'required'
        ]);
        DB::table('client')->insert([
            'nama' => $request->nama,
            'kontrak' => $request->kontrak,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'lokasi' => $request->lokasi,
            'lat' => $request->lat,
            'long' => $request->long,
        ]);
        return redirect('/backend/client')->with('status','Sukses menyimpan data');
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
        $data = DB::table('client')->where('id', $id)->get();
        return view('backend.client.edit', compact('data'));
        
 
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
            'kontrak' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'lokasi' => 'required',
            'lat' => 'required',
            'long'=> 'required'
        ]);
        DB::table('client')->where('id', $id)->update([
            'nama' => $request->nama,
            'kontrak' => $request->kontrak,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'lokasi' => $request->lokasi,
            'lat' => $request->lat,
            'long' => $request->long,
        ]);
        return redirect('/backend/client')->with('status','Sukses merubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('client')->where('id', $id)->delete();
    }
}
