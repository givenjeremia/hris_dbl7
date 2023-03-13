<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\jabatan;
use App\User;
use App\pegawai;
use App\Absen;
use App\cutis;
use App\bpjs;
use App\potongan;
use App\potongangaji;
use App\pendapatangaji;
use App\pendapatan;
use App\mastergaji;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\Updateprofiles;
use App\Http\Requests\ListCuti;
use PDF;


class ResponseContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function resourceJabatan(){
        $data = jabatan::all();
        return response()->json(['data'=>$data], 200);
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
    public function slipgaji(Request $request){
        // check umk
        $id_user = $request->id_user;
        $date = date('m');        
        $check_id =mastergaji::where('type','gaji bersih')->where('role',$id_user)->whereMonth('created_at',$date)->value('id'); 
        if(empty($check_id) === false){
            $data_gaji= mastergaji::where('type','gaji bersih')->where('role',$id_user)->whereMonth('created_at',$date)->paginate(10);
                foreach($data_gaji as $datas){
                $url = url("api/cetakslipgaji?id=$datas->id");
                $data[] = [
                    'gaji_id'=>$datas->id,
                    'gaji_total'=>$datas->data,
                    'gaji_tanggal'=>$datas->created_at,
                    'slipgaji_download'=>$url
                    ];
                } 
            if(empty($data) === false){ 
                return response()->json(['message'=>'Berhasil Mendapatkan Data','data'=>$data], 200);
            }
            else{
                return response()->json(['error'=>'page not found'], 404);
            }
        }
        else{
        return response()->json(['error'=>'user id not found'], 404);
    }
    }
    public function cetakslipgaji(Request $request){
        $id_user = pendapatangaji::where('slug_id',$request->id)->value('id_user');
        $nama = pegawai::where('id',$id_user)->value('nama');
        $id_jabatan = pegawai::where('id',$id_user)->value('id_jabatan');
        $jabatan = jabatan::where('id',$id_jabatan)->value('nama');
        $id_divisi = pegawai::where('id',$id_user)->value('id_divisi');
        $divisi = DB::table('divisi')->where('id',$id_divisi)->value('nama');
        $data_pendapatan = pendapatangaji::where('slug_id',$request->id)->get();
        $data_potongan = potongangaji::where('slug_id',$request->id)->get();
        $totalgaji = mastergaji::where('id',$request->id)->value('data');
        // $pdf = Pdf::loadView('slipgaji_pdf', ['name' => 'James']);
        $pdf = Pdf::loadView('slipgaji_pdf', [
            'name' => $nama,
            'pendapatan'=>$data_pendapatan,
            'potongan'=>$data_potongan,
            'jabatan'=>$jabatan,
            'divisi'=>$divisi,
            'totalgaji'=>$totalgaji
        ]);
        return $pdf->download("laporan-pegawai-slipgaji $nama jabatan:$jabatan");
        return response()->json([
            'message' =>'succes download data',
            
        ], 200);
    }
    public function updateProfile(Updateprofiles $request){
            DB::table('pegawai')->where('id', $request->user_id)->update([
                'nama' => $request->user_nama,
            ]);
            $check = empty($request->user_password);
                if($check){
                    User::where('id_pegawai',$request->user_id)->update([
                    'name' => $request->user_nama,
                    'telp' => $request->user_no_hp,
                    'gambar'=>$request->user_url_photo
                ]);
                }
                elseif($check === false){
                    User::where('id_pegawai',$request->user_id)->update([
                        'name' => $request->user_nama,
                        'telp' => $request->user_no_hp,
                        'gambar'=>$request->user_url_photo,
                        'password'=>Hash::make($request->user_password)
                ]);
                }

            
            return response()->json(["message" =>"Berhasil Mengupdate Profile Anda"], 200);
    }
    public function hapusdata(Request $request){
        Absen::where('id_pegawai',$request->id_pegawai)->where('date',$request->absensi_tanggal)->delete();
        return response()->json(['message'=>'berhasil menghapus data'],200);
    }
        /*
    "user_id" : 1,
    "tahun" : 2022, // "Jika tahun kosong, maka akan get semua data cuti"
    "page" : 1
    
        "cuti_id" : 1,
        "cuti_mulai_tanggal": "2022-09-06T09:07:11.000Z",
        "cuti_sampai_tanggal": "2022-09-12T09:07:11.000Z",
        "cuti_status" : "Diterima"*/
    public function listcuti(ListCuti $request){
        $data_cuti=[];
    if(empty($request->tahun)===false){
        $data = cutis::where('id_pegawai',$request->user_id)->whereYear('created_at',$request->tahun)->paginate(10);
        foreach($data as $d){
            $datas_cuti = ['cuti_id'=>$d->id,"cuti_mulai_tanggal"=>$d->mulai,"cuti_sampai_tanggal"=>$d->akhir, "cuti_status"=>$d->status];
            $data_cuti[] =$datas_cuti;
        }
    }
    elseif(empty($request->tahun)===true){
        $data = cutis::where('id_pegawai',$request->user_id)->paginate(10);
        foreach($data as $d){
            $datas_cuti = ['cuti_id'=>$d->id,"cuti_mulai_tanggal"=>$d->mulai,"cuti_sampai_tanggal"=>$d->akhir, "cuti_status"=>$d->status];
            $data_cuti[] =$datas_cuti;
        }
    }
        $return_data = ['message'=>"Berhasil Mendapatkan Data",'data'=>$data_cuti];
        return response()->json($return_data, 200);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  int  $page
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }
    public function listAbsen(Request $request){
    $data_absen =[];
        /*
        "absensi_id" : 2,
        "absensi_tanggal": "2022-09-06T09:07:11.000Z",
        "absensi_status" : false // masuk terlambat,
        "absensi_keterangan":10,
        "absensi_masuk" : false,*/
            $data = Absen::where('id_pegawai',$request->id_user)->paginate(10);
            if(empty($data)===false){      
            foreach($data as $d){
                if($d->status === 'terlambat'){
                    $status='false';
                }
                elseif($d->status === 'tepat waktu'){
                    $status='true';
                }
            $data_status = $status;
            $tanggal_masuk="$d->date:$d->masuk";
            $finis_data_masuk = ["absensi_id"=>$d->id,"absensi_tanggal"=>$tanggal_masuk,"absensi_status"=>$data_status,"absensi_keterangan"=>$d->keterangan,"absensi_masuk"=>true];
            $data_absen[] =$finis_data_masuk;
            if(empty($d->pulang)===false){
                $tanggal_pulang="$d->date:$d->pulang";
                $finis_data_pulang = ["absensi_id"=>$d->id,"absensi_tanggal"=>$tanggal_pulang,"absensi_masuk"=>false];
                $data_absen[] =$finis_data_pulang;
            }
            
            }}
        $return_data = ['message'=> "Berhasil Mendapatkan Data",'data'=>$data_absen];
        return response()->json($return_data,200);
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
