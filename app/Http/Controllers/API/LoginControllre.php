<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\jabatan;
use App\pegawai;
use App\client;
use DB;
use App\JadwalShift;
use Illuminate\Support\Facades\Auth;
use App\newshift;
use Validator;

class LoginControllre extends Controller
{
    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('nApp')->accessToken;
            $id = $user->id_pegawai;
            $id_kantor = client::select('id')->get();
            $id_kantor = pegawai::where('id',$id)->value('id_kantor');
            $lat = client::where('id',$id_kantor)->value('lat');
            $long = client::where('id',$id_kantor)->value('long');
            $jabatan_id = pegawai::where('id',$id)->value('id_jabatan');
            $devisi_id = pegawai::where('id',$id)->value('id_divisi');
            $date = date('Y-m-d');
            $slug_date =date('Y-m-01');
            $data_hari = (int)date('d');
            $datacepat =  DB::table('setting_absen')->value('palingcepat');
            $datalambat =  DB::table('setting_absen')->value('palinglambat');
            $datacepatpulang =DB::table('setting_absen')->value('palingcepat');
            // check shift pegawai
            $check_shift = newshift::where('date_start',$slug_date)->where('Ids',$id)->where('type','Pegawai')->value($data_hari);
           if(empty($check_shift)===false){
            $check_shift_pegawai = newshift::where('date_start',$slug_date)->where('Ids',$id)->where('type','Pegawai')->value($data_hari);
            $masuk = DB::table('shift')->where('id',$check_shift_pegawai)->value('jam_masuk');
            $pulang = DB::table('shift')->where('id',$check_shift_pegawai)->value('jam_pulang');
           }
            elseif(empty($check_shift)=== true){
            $check_shift_jabatan = newshift::where('date_start',$slug_date)->where('Ids',$jabatan_id)->where('type','Jabatan')->value($data_hari);
            $masuk = DB::table('shift')->where('id',$check_shift_jabatan)->value('jam_masuk');
            $pulang = DB::table('shift')->where('id',$check_shift_jabatan)->value('jam_pulang');
            }
            elseif(empty($check_shift_jabatan)=== true){
                $check_shift_devisi = newshift::where('date_start',$slug_date)->where('Ids',$devisi_id)->where('type','Devisi')->value($data_hari);
                $masuk = DB::table('shift')->where('id',$check_shift_devisi)->value('jam_masuk');
                $pulang = DB::table('shift')->where('id',$check_shift_devisi)->value('jam_pulang');
            }

            $palinglambat=date_format(date_add(date_create($masuk), date_interval_create_from_date_string($datalambat)),'H:i');
            $palingcepat=date_format(date_add(date_create($masuk), date_interval_create_from_date_string(" -$datacepat")),'H:i');
            $paling_cepat_pulang=date_format(date_add(date_create($pulang), date_interval_create_from_date_string(" -$datacepatpulang")),'H:i');
            
            return response()->json([
                'message'=>"Berhasil Login",
                'data' =>([
                    'user_id'=> $id,
                    'user_nama'=>$user->name,
                    'user_jabatan_id'=>$jabatan_id,
                    'user_email'=>$user->email,
                    'user_no_hp'=>$user->telp,
                    "user_mulai_shift" => $masuk,
                    "user_sampai_shift" => $pulang,
                    "user_mulai_awal" =>$palingcepat,
                    "user_mulai_terlambat"=>$palinglambat,
                    "user_id_kantor"=>$id_kantor,
                    "user_kantor_latitude"=>$lat,
                    "user_kantor_longitude"=>$long,
                    "user_url_photo"=>$user->gambar,
     
                ]),
                'auth'=>$success,
        
        ], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Password atau email anda salah'], 401);
        }
    }

}
