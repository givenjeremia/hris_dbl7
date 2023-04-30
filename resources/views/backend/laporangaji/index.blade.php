@extends('layouts/base')

@section('token')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('customcss')
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection

@section('content')
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Laporan Gaji Karyawan</h1>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container">
        @if (session('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>Info!</h4>
            {{ session('status') }}
        </div>
        @endif
        <div class="row " >
     
            <div class="col">
                    <div class="row ">
                        <label for="exampleInputEmail1">Tanggal</label>
                        <div class="col">

                            <div class="form-group">
                                <input type="month" id="sort_by" class="form-control" name="sort_by" required>
                            </div>
            
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{-- <p></p> --}}
                                <div></div>
                                <button type="button" id="btncari" class="btn btn-primary ">Cari</button>
                                <div></div>
                                
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{-- <p></p> --}}
                                <div></div>
                                <button type="button" id="btnhitungperhitungangaji" class="btn btn-primary ">Hitung Gaji</button>
                                <div></div>
                                
                            </div>
                        </div>
                    </div>
                
                
            </div>
          
            <p id="test"></p>
            
            <div id="table-laporan">
                
            </div>
          
        </div>
    </div><!-- /.container-fluid -->
</div>
@endsection

{{-- @push('customjs')
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

@endpush

@push('customscripts')
<script src="{{asset('customjs/backend/lg.js')}}"></script>

@endpush --}}

@section('js')
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script> 

<script src="{{asset('customjs/backend/lg.js')}}"></script>

@endsection