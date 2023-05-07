<?php

namespace App\Http\Controllers\backend;

use App\Shift;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.data.shift.index');
    }

    public function listdata(){
        
        return Datatables::of(DB::table('shift')
        ->get())->make(true);
    }
    public function listdataajax(){
        return Datatables::of(DB::table('shift')
        ->crossJoin('new_jadwal_shifts as jd')
        ->select('shift.*','jd.id as id_shift')
        ->get())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $request->validate([
            'nama' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required'
        ]);
        $check = Shift::where('nama',$request->nama)->where('jam_masuk',$request->jam_masuk)->where('jam_pulang', $request->jam_pulang)->get();
        if(count($check) == 0){

            DB::table('shift')->insert([
                'nama' => $request->nama,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
            ]);
            return redirect('/backend/shift')->with('status','Sukses menyimpan data');
        }
        else{
            return redirect('/backend/shift')->with('gagal','Gagal menyimpan data');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
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
            'jam_masuk' => 'required',
            'jam_pulang' => 'required'
        ]);
        $check = Shift::where('nama',$request->nama)->where('jam_masuk',$request->jam_masuk)->where('jam_pulang', $request->jam_pulang)->get();
        if(count($check) == 0){

            DB::table('shift')->where('id', $id)->update([
                'nama' => $request->nama,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
            ]);
            return redirect('/backend/shift')->with('status','Sukses merubah data');
        }
        else{
            return redirect('/backend/shift')->with('gagal','Gagal merubah data');
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('shift')->where('id', $id)->delete();
    }

    public function getEditForm(Request $request){

        $id = $request->get('id');
        $shift = Shift::find($id);
        // dd($shift);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('backend.data.shift.edit_modal', compact('shift'))->render()
        ),200);
    }

}
