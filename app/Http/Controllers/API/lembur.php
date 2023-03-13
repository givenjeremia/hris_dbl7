<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use DataTables;
use App\lemburmodel;

class lembur extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addlembur(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'lembur_deskripsi' => 'required',
            'lembur_date' => 'required',
            'lembur_start' => 'required',
            'lembur_end' => 'required',
            
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $lembur_date =  date_create(date("Y-m-d", strtotime($request->lembur_date)));
        $lembur_start =  date_create(date("H:i", strtotime($request->lembur_start)));
        $lembur_end =   date_create(date("H:i", strtotime($request->lembur_end)));
        $lembur = lemburmodel::create([
            'date' => $lembur_date,
            'start_time' => $lembur_start,
            'end_time' => $lembur_end,
            'keterangan' => $request->lembur_deskripsi,
            'user_id'=> $request->user_id,
            'status'=> 'pending',
    
        ]) ;
        //    response
        if ($lembur){
            return response()->json([  "message"=>"Berhasil Menambahkan Lembur"], 200);
        }
        else{
            return response()->json(["error"=>"Terjadi Kesalahan"],501);
        }
    }
}
