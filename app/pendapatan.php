<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pendapatan extends Model
{
    protected $table = 'pendapatans';
    protected $fillable = [
        'data',
        'type',
        'role',
        
    ];
    public function nama()
    {
        return $this->hasOne('App\jabatan','id','role');
    }

    public function p_bpjs()
    {
        return $this->belongsTo('App\potongangaji','potonganbpjs_id');
    }
    public function p_gaji()
    {
        return $this->belongsTo('App\potongangaji','potongangajis_id');
    }
    public function pegawai()
    {
        return $this->belongsTo('App\pegawai','pegawai_id');
    }

    public function perhitunganGaji(){

    }
    
    public function showGaji($pendapatan)
    {
        $jabatan = jabatan::all();
        $gaji = [];
        foreach ($pendapatan as $key => $value) {
            $jabatan_id = $value->pegawai->jabatan_id;
            // dd($jabatan_id);
            $nama_pegawai = $value->pegawai->nama;
            $tanggal = $value->created_at;
            $gaji_bersih = $value->nominal;
            $gaji_pokok = 0;
            $tunjangan_keahlian = 0;
            foreach ($jabatan as $key2 => $value2) {
                if($value2->id == $jabatan_id){
                    $gaji_pokok = $value2->nominal_gaji;
                    $tunjangan_keahlian = $value2->divisi->nominal_tunjangan;
                }
            }
            $tlb = $value->nominal_tlb;
            $lemburs = $value->nominal_lemburs;
            $potongan_gaji = $value->p_gaji->nominal;
            $potongan_bpjs = $value->p_bpjs->nominal;
            $status_pembayaran = $value->status;

            array_push(
                $gaji,
                [
                    'id_pendapatan'=>$value->id,
                    'nama_pegawai'=>$nama_pegawai,
                    'tanggal'=>$tanggal,
                    'gaji_bersih'=> $gaji_bersih,
                    'gaji_pokok'=>$gaji_pokok,
                    'tunjangan_keahlian'=>$tunjangan_keahlian,
                    'tunjangan_lama_bekerja'=>$tlb,
                    'potongan_gaji'=>$potongan_gaji,
                    'potongan_bpjs'=>$potongan_bpjs,
                    'lembur'=>$lemburs,
                    'status_pembayaran' => $status_pembayaran
                ]
            );
        }
        return $gaji;
    }
    
}
