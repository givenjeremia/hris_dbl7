<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Absen;
use App\cutis;
use App\terlambat;
use App\JadwalShift;
use App\newshift;
use DB;
use Validator;
use App\Http\Resources\AbsenResource;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //    data
        $latlong = DB::table('client')->pluck('latlong');
        return new AbsenResource(['latlong'=>$latlong]);
    }
    
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ////////////////////////////////////////////////////////////////////////////////////////
        // check max terlambat      
            function absen ($data,$dates){
                date_default_timezone_set('Asia/Jakarta'); 
                // // check shift today
                $shift =0;
                $date =strtotime($dates);
                $day = (int)date('d',$date);
                $slug_date = date('Y-m-01',$date);
                $devisi_id = DB::table('pegawai')->where('id',$data)->value('id_divisi');
                $jabatan_id = DB::table('pegawai')->where('id',$data)->value('id_jabatan');
                $user_id = $data;
                $by_id_devisi =newshift::where('date_start',$slug_date)->where('Ids',$devisi_id)->value($day);
                $by_id_jabatan =newshift::where('date_start',$slug_date)->where('Ids',$jabatan_id)->value($day);
                $by_id_user= newshift::where('date_start',$slug_date)->where('Ids',$user_id)->value($day);
                    if(empty($by_id_user) === false){
                    $shift= newshift::where('date_start',$slug_date)->where('Ids',$user_id)->value($day);
                return $shift;    
                }
                elseif(empty($by_id_jabatan) === false){
                    $shift= newshift::where('date_start',$slug_date)->where('Ids',$jabatan_id)->value($day);
                    return $shift;     
                }
                    elseif(empty($by_id_devisi) === false){
                        $shift= newshift::where('date_start',$slug_date)->where('Ids',$devisi_id)->value($day);
                        return $shift;     
                    }
                    return $shift;
            }
            /*by id user check shift*/
            date_default_timezone_set('Asia/Jakarta'); 
            // // check shift today
            $date = $request->absensi_tanggal;
            $check_shift = absen($request->user_id,$request->absensi_tanggal);
            $masuks = '';
            $pulangs = '';
            if($check_shift === 0 ){
            return response()->json(['message' => 'shift tidak tersedia untuk hari ini']);
            }
            elseif($check_shift < 0){
                $masuks = DB::table('shift')->where('id',$check_shift)->value('jam_masuk');
                return $masuks;
            }
            elseif($check_shift < 0){
                $pulangs = DB::table('shift')->where('id',$check_shift)->value('jam_pulang');
                return $pulangs;
            }
            $datacepat =  DB::table('setting_absen')->value('palingcepat');
            $datalambat =  DB::table('setting_absen')->value('palinglambat');
            $i = date_create($masuks);
            $Imasuk = idate('U',date_timestamp_get($i));
            $masuk =strtotime($request->time) ;
            $m = date('H:i',$masuk);
            $M = date_create($m);
            $imasuk = idate('U',date_timestamp_get($M));
            $date = $request->absensi_tanggal;
            $selisih = date_diff($M,$i);
            $palinglambat=idate('U',date_timestamp_get(date_add(date_create($masuks), date_interval_create_from_date_string($datalambat))));
            $palingcepat=idate('U',date_timestamp_get(date_add(date_create($masuks), date_interval_create_from_date_string(" -$datacepat"))));
            // check max
            // check max absen
            $checkabsenhari_pulang = Absen::where('date',$request->absensi_tanggal)->where('id_pegawai',$request->user_id)->value('pulang');
            $checkabsenhari_masuk = Absen::where('date',$request->absensi_tanggal)->where('id_pegawai',$request->user_id)->value('masuk');
    if($request->absensi_masuk === 'true'){
        if(empty($checkabsenhari_masuk)=== true){
            if($imasuk > $palinglambat){
                return response()->json(['error' => "Mohon maaf tidak bisa absen dikarenakan terlambat",$imasuk,$palinglambat,$masuks],400);
                }
                elseif($imasuk < $palingcepat){
                return response()->json(['error' => "Mohon maaf tidak bisa absen dikarenakan terlalu cepat"],400);   
                }
                if($imasuk <= $palinglambat){
                            $absen = [];
                            /*
                            "user_id" : 1,
                            "absensi_masuk": true // Jika True maka absensi masuk
                            "absensi_tanggal": "2022-09-06",
                            "absensi_latitude":"-7.356809425509137", 
                            "absensi_longitude":"112.73674328675942",
                            "absensi_lokasi" : "Jalan 30. Kecamatan Nganjuk, Kabupaten Nganjuk",
                            "time":'07:58',
                            "id_kantor" : 1*/
                        // Masuk Terlambat
                        
                            if ($Imasuk < $imasuk){
                                $keterangan= ['terlambat',', ',$selisih->h,' ','jam',', ',$selisih->i,' ','menit'];
                                $absen= Absen::insert([
                                    'id_pegawai' =>$request->user_id,
                                    'id_client' => $request->id_kantor,
                                    'masuk' => $m,
                                    'status' => 'terlambat',
                                    'keterangan' => implode($keterangan),
                                    'date' => $date,
                                    'lat_masuk'=>$request->absensi_latitude,
                                    'long_masuk' => $request->absensi_longitude,
                                    'lokasi_masuk'=>$request->absensi_lokasi
                                    ]);
                                    terlambat::insert([
                                        'id_pegawai'=> $request->user_id,
                                        'masuk' => $selisih->i,
                                        'pulang'=>0,
                                        'date' => $date,
                                        ]);
                            
                                    if($absen){
                                        $k = implode($keterangan);
                                        $respons =["Berhasil Melakukan Absensi Masuk $k "] ;
                                        return response()->json([ 'message' => implode($respons)]);
                                        }
                                        else{
                                        return response()->json([  "error" => "Terjadi Kesalahan"],400);
                                        }
                            
                            }

                                elseif($Imasuk >= $imasuk){
                                $keterangan= ['tepat waktu'];
                                    $absen= Absen::insert([
                                    'id_pegawai' => $request->user_id,
                                    'id_client' => $request->id_kantor,
                                    'masuk' => $m,
                                    'status' => 'tepat waktu',
                                    'keterangan' => implode($keterangan),
                                    'date' => $date,
                                    'lat_masuk'=>$request->absensi_latitude,
                                    'long_masuk' => $request->absensi_longitude,
                                    'lokasi_masuk'=>$request->absensi_lokasi
                                    ]);
                                    if($absen){
                                        $k = implode($keterangan);
                                        $respons =["Berhasil Melakukan Absensi Masuk $k "] ;
                                        return response()->json([ 'message' => implode($respons)]);
                                        }
                                        else{
                                        return response()->json([  "error" => "Terjadi Kesalahan"],400);
                                        }
                        }
                    }
        }
        elseif(empty($checkabsenhari_masuk)=== false){
            return response()->json(['error'=>"anda telah absen masuk"], 400,);
        }
    }
    
    elseif($request->absensi_masuk === 'false'){
        if(empty($checkabsenhari_pulang)=== true){
                        $i = date_create($pulangs);
                        $Imasuk = idate('U',date_timestamp_get($i));
                        $masuk =strtotime($request->time) ;
                        $m = date('H:i',$masuk);
                        $M = date_create($m);
                        $imasuk = idate('U',date_timestamp_get($M));
                        $date = $request->absensi_tanggal;
                        $selisih = date_diff($M,$i);
                        $absen = [];
                        $keterangan= ['pulang lebih cepat',' ',$selisih->i,' ','menit'];
                        $id_absen = Absen::where('date',$date)->where('id_pegawai',$request->user_id)->value('id');
                        $id_terlambat = terlambat::where('date',$date)->where('id_pegawai',$request->user_id)->value('id');
                            if($Imasuk > $imasuk){
                                $old_keterangan = Absen::where('date',$date)->where('id_pegawai',$request->user_id)->value('keterangan');
                                $keterangan_new = [$old_keterangan ,$keterangan];
                                $absen= Absen::where('id', $id_absen)->update([
                                    'pulang' => $m,
                                    'lat_pulang'=>$request->absensi_latitude,
                                    'long_pulang' => $request->absensi_longitude,
                                    'lokasi_pulang'=>$request->absensi_lokasi,
                                    'keterangan' => implode($keterangan_new)
                                    ]);
                            terlambat::where('id', $id_terlambat)->update([
                            'pulang' => $selisih->i,
                            ]);
                            if($absen){
                                $respon = implode($keterangan);
                                $respons =["Berhasil Melakukan Absensi pulang $respon"] ;
                                return response()->json([ 'message' => implode($respons)]);
                                }
                                else{
                                return response()->json([  "error" => "Terjadi Kesalahan"],400);
                                }
                            }
                            elseif($Imasuk < $imasuk){
                            $keterangan= ['hati-hati dijalan'];
                            $absen= Absen::where('id', $id_absen)->update([
                            'pulang' => $m,
                            'lat_pulang'=>$request->absensi_latitude,
                            'long_pulang' => $request->absensi_longitude,
                            'lokasi_pulang'=>$request->absensi_lokasi
                            ]);
                            if($absen){
                                $respon = implode($keterangan);
                                $respons =["Berhasil Melakukan Absensi pulang $respon"] ;
                                return response()->json([ 'message' => implode($respons)]);
                                }
                                else{
                                return response()->json([  "error" => "Terjadi Kesalahan"],400);
                                }
                            }
                            
        }
        elseif(empty($checkabsenhari_pulang)=== false){
            return response()->json(['error'=>"absen hari ini sudah complit"], 400,);
        } 

            
                // convert data
        
    }
        
 
        
        
    else{
            return response()->json(['error'=>"server not request for you"], 500,);
        }
    }
        

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @param  int  $date
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            return response()->json($id, 200);
        }
        public function check($id,$date)
        {
            // check data shift 
            $masters=DB::table('jadwal_shifts')->where('date',$date)->get();
            // $id_jabatan = 
            //         //check jabatan 
            //         foreach($masters as $master){
            //             if($master->type == 'Jabatan'){
            //             return response()->json();
            //             }
            //         }
                    
                    
            
        // //    data
        //     date_default_timezone_set('Asia/Jakarta');
        //     $lat = DB::table('client')->pluck('lat');
        //     $long =DB::table('client')->pluck('long');
        //     $latlong = $lat.$long;
        //     $M = DB::table('absensi')->where('id_pegawai',$id)->value('masuk');
        //     $P = DB::table('absensi')->where('id_pegawai',$id)->value('pulang');
        //     $masuk_time = DB::table('absensi')->where('id_pegawai',$id)->value('masuk');
        //     $pulang_time = date('h:m:s');
        //     $masuk = is_null($M);
        //     $pulang = is_null($P);
        // //    if
        //     if($masuk){
        //         return new AbsenResource([
        //             'latlong' => $latlong,
        //             'masuk' => false,
        //             'pulang' => false,
        //             'time' => $masuk_time,
        //             'status' => 'absen masuk'
        //     ]);
        //     }
        //     elseif(!$pulang and !$masuk){
        //         return new AbsenResource([
        //             'message' => 'absen sudah komplit'
        //     ]);
        //     }
        //     elseif(!$masuk){
        //         return new AbsenResource([
        //             'latlong' => $latlong,
        //             'masuk' => true,
        //             'pulang' => false,
        //             'time' => $pulang_time,
        //             'status' => 'Absen pulang'
        //     ]);
        //     }
        //     else{
        //         return new AbsenResource([
        //             'message'=>'respon error Not found',
        //             'error' => 404
        //         ]);
        //     }

            
        
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
