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
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Data Gaji Karyawan </h3>
                        <div class="card-tools">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="list-data" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <th>Date</th>
                                        <th>Gaji Bersih</th>
                                        <th>Gaji Pokok</th>
                                        <th>Tunjangan Keahlian</th>
                                        <th>Tunjangan Lama Berkerja</th>
                                        <th>Potongan Bpjs</th>
                                        <th>Potongan Gaji</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                      
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td id="nama_{{$row->id}}"></td>
                                    @php
                                        $dates=strtotime($row->created_at);
                                        $date = date('Y-m-d',$dates);
                                    @endphp
                                    <td>{{$date}}</td>
                                    <td id="bersih_{{$row->id}}"></td>
                                    <td id="umk_{{$row->id}}"></td>
                                    <td id="tk_{{$row->id}}"></td>
                                    <td id="tlb_{{$row->id}}"></td>
                                    <td id="bpjs_{{$row->id}}"></td>
                                    <td id="potongan_{{$row->id}}"></td>
                                    <td><button class="btn btn-danger" onclick="hapusdata({{$row->id}})"><i class="fa fa-trash"></i></button></td>
                                </tr>
                            @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <th>Date</th>
                                        <th>Gaji Bersih</th>
                                        <th>Gaji Pokok</th>
                                        <th>Tunjangan Keahlian</th>
                                        <th>Tunjangan Lama Berkerja</th>
                                        <th>Potongan Bpjs</th>
                                        <th>Potongan Gaji</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
@endsection

@push('customjs')
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@endpush

@push('customscripts')
<script src="{{asset('customjs/backend/lg.js')}}"></script>
@endpush