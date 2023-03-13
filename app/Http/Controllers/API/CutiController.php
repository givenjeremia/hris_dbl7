<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\cutis;


class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        date_default_timezone_set('Asia/Jakarta'); 
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'cuti_deskripsi' => 'required',
            'cuti_subjek' => 'required',
            'cuti_mulai_tanggal' => 'required',
            'cuti_sampai_tanggal' => 'required',
            
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $name=DB::table('users')->where('id_pegawai',$request->user_id)->value('name');
    
        $cuti = cutis::insert([
            'nama' => $name,
            'mulai' => $request->cuti_mulai_tanggal,
            'akhir' => $request->cuti_sampai_tanggal,
            'keterangan' => $request->cuti_deskripsi,
            'subjek' => $request->cuti_subjek,
            'id_pegawai'=> $request->user_id,
            'status'=> 'pending',
            'created_at' => date('Y-m-d H:s:i'),
    
        ]) ;
        //    response
        if ($cuti){
            return response()->json([  "message"=>"Berhasil Menambahkan Cuti"], 200);
        }
        else{
            return response()->json(["error"=>"Terjadi Kesalahan"],501);
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
