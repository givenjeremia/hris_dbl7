<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
class exportController extends Controller
{  
public function cetakslipgaji(Request $request){
        $pdf = Pdf::loadView('slipgaji_pdf');
        return $pdf->download('laporan-pegawai-pdf');
}
}
