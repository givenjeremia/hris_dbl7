<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

    public function listdata()
    {
        return DataTables::of(DB::table('client')->where('delete_at',0)->get())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('backend.client.create');
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
            'email' => 'required',
            'alamat' => 'required',
            'lokasi' => 'required',
            'lat' => 'required',
            'long' => 'required'
        ]);
        DB::table('client')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'lokasi' => $request->lokasi,
            'lat' => $request->lat,
            'long' => $request->long,
        ]);
        return redirect('/backend/client')->with('status', 'Sukses menyimpan data');
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
            'email' => 'required',
            'alamat' => 'required',
            'lokasi' => 'required',
            'lat' => 'required',
            'long' => 'required'
        ]);
        DB::table('client')->where('id', $id)->update([
            'nama' => $request->nama,
            'email' => $request->email,

            'alamat' => $request->alamat,
            'lokasi' => $request->lokasi,
            'lat' => $request->lat,
            'long' => $request->long,
        ]);
        return redirect('/backend/client')->with('status', 'Sukses merubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        // DB::table('client')->where('id', $id)->delete();
        DB::table('client')->where('id', $id)->update([
            'delete_at' => 1
        ]);
    }

    public function showModalKontrak($id){
        $kontrak = DB::table('kontrak')->where('client_id',$id)->get();
        $client = DB::table('client')->where('id',$id)->first();
        // dd($kontrak);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('backend.client.kontrak.index', compact('kontrak','client'))->render()
        ),200);
        
    }
    public function showModalTambahKontrak($id){
        $client = DB::table('client')->where('id',$id)->first();
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('backend.client.kontrak.create', compact('client'))->render()
        ),200);
    }
    public function tambahKontrak(Request $request){
        $tanggal_akhir = $request->tanggaL_akhir;
        DB::table('kontrak')->insert([
            'nama' => $request->get('nama'),
            'tanggal_mulai' => $request->get('tanggal_mulai'),
            'tanggal_akhir' => $tanggal_akhir ,
            'client_id' => $request->get('data_client'),
        ]);
        return redirect('/backend/client')->with('status', 'Sukses menyimpan data');
        
    }

    public function cekNama(Request $request){
        $nama = $request->get('value');
        $client = DB::table('client')->where('nama',$nama)->get();
        if(count($client) > 0){
            return response()->json(array(
                'status'=>'ada',
            ),200);
        }
        else{
            return response()->json(array(
                'status'=>'kosong',
            ),200);
        }
        
    }

}
