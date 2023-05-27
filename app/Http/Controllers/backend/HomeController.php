<?php

namespace App\Http\Controllers\backend;

use App\User;

use App\devisi;
use App\jabatan;
use App\pegawai;
use App\newshift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    //=================================================================
    public function index()
    {
       $date_now = Carbon::now()->toDateString();
       $cuti_pending = count(DB::table('cutis')->where('status','pending')->get());
    //    $lembur_pending = count(DB::table('lemburs as l')
    //    ->where('status','Diterima')
    //    ->leftjoin('pegawai as p','l.pegawai_id','=','p.id')
    //    ->select('l.*','p.nama as nama')
    //    ->orwhere('status','Ditolak')
    //    ->get());
       $pegawai_terlambat = DB::table('absensi')
                    ->join('pegawai', 'absensi.pegawai_id', '=', 'pegawai.id')
                    ->join('client', 'absensi.client_id', '=', 'client.id')
                    ->where('absensi.status', '=', 'terlambat')
                    ->where('absensi.date', '=', $date_now)
                    ->select('absensi.*','pegawai.nama as id_pegawai','client.nama as id_client')
                    ->get();
        // Jadwal Shift
        $shift = newshift::where('tanggal',$date_now)->get();
        $detail_shift = [];
        foreach ( $shift  as $key => $value) {
            $type_name = "";
            if($value->type == "Devisi"){
                $type_name ="Devisi";
               $types = devisi::find($value->Ids);
            }
            elseif($value->type == "Jabatan"){
                $type_name ="jabatan";
                $types = jabatan::find($value->Ids);
            }
            else{
                $type_name ="Pegawai";
                $types= pegawai::find($value->Ids);
            }
            $details = [
                'id_jadwal_shift'=>$value->id,
                'id_shift'=>$value->shift->id,
                'nama_shift'=>$value->shift->nama,
                'id_type'=> $types->id,
                'type_name'=>$types->nama,
                'type_ket'=>$type_name,
                'tanggal' => $value->tanggal,
                'keterangan'=>$value->keterangan,
            ];
            array_push($detail_shift ,$details);
        } 

        return view('backend.dashboard.index',[
            'cuti_pending'=>$cuti_pending,
            // 'lembur_pending'=>$lembur_pending ,
    
            'count_pegawai_terlambat'=> count($pegawai_terlambat),
            'jadwal_shift_today' => $detail_shift
        ]);
    }

    //==================================================================
    public function detailPegawaiTerlambat(){
        $date_now = Carbon::now()->toDateString();
        $pegawai_terlambat = DB::table('absensi')
                    ->join('pegawai', 'absensi.pegawai_id', '=', 'pegawai.id')
                    ->join('client', 'absensi.client_id', '=', 'client.id')
                    ->where('absensi.status', '=', 'terlambat')
                    ->where('absensi.date', '=', $date_now)
                    ->select('absensi.*','pegawai.nama as id_pegawai','client.nama as id_client')
                    ->get();
        // dd($pegawai_terlambat);
        return response()->json(array(
                        'status' => 'oke',
                        'msg' => view('backend.dashboard.detail_pegawai_terlambat',['data'=>$pegawai_terlambat])->render()
        ), 200);
    }

    //==================================================================
    public function editprofile(){
        $data = User::find(Auth::user()->id);
        return view('backend.dashboard.editprofile',['data'=>$data]);
    }

    //==================================================================
    public function aksieditprofile(Request $request,$id){
        if($request->hasFile('gambar')){
            File::delete('img/admin/'.$request->gambar_lama);
            $nameland=$request->file('gambar')->
            getClientOriginalname();
            $lower_file_name=strtolower($nameland);
            $replace_space=str_replace(' ', '-', $lower_file_name);
            $finalname=time().'-'.$replace_space;
            $destination=public_path('img/admin');
            $request->file('gambar')->move($destination,$finalname);

            if($request->password==''){
                User::find($id)
                ->update([
                    'name'=>$request->nama,
                    'username'=>$request->username,
                    'email'=>$request->email,
                    'telp'=>$request->telp,
                    'gambar'=>$finalname,
                ]);
            }else{
                User::find($id)
                ->update([
                    'name'=>$request->nama,
                    'username'=>$request->username,
                    'email'=>$request->email,
                    'telp'=>$request->telp,
                    'gambar'=>$finalname,
                    'password'=>Hash::make($request->password),
                ]);
            }
        }else{
            if($request->password==''){
                User::find($id)
                ->update([
                    'name'=>$request->nama,
                    'username'=>$request->username,
                    'email'=>$request->email,
                    'telp'=>$request->telp,
                ]);
            }else{
                User::find($id)
                ->update([
                    'name'=>$request->nama,
                    'username'=>$request->username,
                    'email'=>$request->email,
                    'telp'=>$request->telp,
                    'password'=>Hash::make($request->password),
                ]);
            }
        }

        return redirect('/backend/home')->with('status','Sukses memperbarui profile');
    }

    //==================================================================
    public function websetting()
    {
        $data = DB::table('settings')->orderby('id','desc')->get();
        return view('backend.dashboard.websetting',compact('data'));
    }

    //==================================================================
    public function updatewebsetting(Request $request)
    {
        DB::table('settings')->where('id',$request->kode)
        ->update([
            'singkatan_nama_program'=>$request->singkatan_nama_program,
            'nama_program'=>$request->nama_program,
            'instansi'=>$request->instansi,
            'deskripsi_program'=>$request->deskripsi,
        ]);
        return redirect('/backend/home')->with('status','Sukses memperbarui setting web');
    }
}
