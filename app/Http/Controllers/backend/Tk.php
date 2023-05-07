<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\newshift;
use App\pendapatan;

class Tk extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $divisi = DB::table('divisi')->orderby('nama', 'asc')->get();
        return view('backend.tk.index', compact('divisi'));
    }
    public function listdata()
    {
        return Datatables::of(DB::table('pendapatans')
            ->where('type', 'tunjangan keahlian')
            ->join('divisi', 'pendapatans.role', '=', 'divisi.id')
            ->select('pendapatans.*', 'divisi.nama as nama')
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

        $request->validate([
            'jumlah' => 'required',
            'role' => 'required',
        ]);
        $check = pendapatan::where('type', 'tunjangan keahlian')->where('role', $request->role)->get();
        if (count($check) > 0) {
            return redirect('/backend/tunjangankeahlian')->with('gagal', 'Gagal menyimpan data');
        } else {
            pendapatan::create([
                'data' => $request->jumlah,
                'role' => $request->role,
                'type' => 'tunjangan keahlian'
            ]);
            return redirect('/backend/tunjangankeahlian')->with('status', 'Sukses menyimpan data');
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
            'jumlah' => 'required',
            'role' => 'required',
        ]);
        $pendapatan_check = pendapatan::find($id);
        $role_now = $pendapatan_check->role;
        $check = pendapatan::where('type', 'tunjangan keahlian')->where('role', $request->role)->get();
        if($role_now == $request->role || count($check) == 0){
            pendapatan::where('id', $id)->update([
                'data' => $request->jumlah,
                'role' => $request->role,
                'type' => 'tunjangan keahlian'
            ]);
            return redirect('/backend/tunjangankeahlian')->with('status', 'Sukses merubah data');
        }
        else{
            return redirect('/backend/tunjangankeahlian')->with('gagal', 'Gagal menyimpan data');

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
        pendapatan::where('id', $id)->delete();
    }

    public function getEditForm(Request $request)
    {
        // dd("Masuk");
        $id = $request->get('id');
        $tk = DB::table('pendapatans')->where('type', 'tunjangan keahlian')->where('id', $id)->get();
        $divisi = DB::table('divisi')->orderby('nama', 'asc')->get();
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('backend.tk.edit_modal', compact('tk', 'divisi'))->render()
        ), 200);
    }
}
