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
                <h1 class="m-0 text-dark">Lembur</h1>
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
        @if (session('danger'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>Info!</h4>
            {{ session('danger') }}
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Data lembur</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal"
                                data-target="#exampleModal">
                                <i class="fas fa-plus"></i> Tambah
                                Data
                            </button>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="list-data" class="table table-bordered table-striped">
                                <thead>
                                    {{-- nama pegawai, judul, keterangan, tgl mulai, tgl akhir, status --}}
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <th>Tanggal</th>
                                        <th>Lama Lembur</th>
                                        <th>Keterangan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tbody>
                                        @foreach ($lembur as $key => $row)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{ $row->pegawai->nama }}</td>
                                            <td>{{ date("j F Y", strtotime($row->tanggal)) }}</td>
                                            <td>{{ $row->lama_lembur }}</td>
                                            <td>{{ $row->keterangan }}</td>
                                            <td>
                                                <a href="#modalEdit" data-toggle="modal" onclick="getEditForm(' + row['id'] + ')"  class="btn btn-success" ><i class="fa fa-wrench"></i></a>
                                                <button class="btn btn-danger" onclick="hapusdata(' + row['id'] + ')"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <th>Tanggal</th>
                                        <th>Lama Lembur</th>
                                        <th>Keterangan</th>
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

{{-- Tambah Lembur --}}
@include('backend/lembur/modal_create')
<!-- Modal -->
                            <!-- Button trigger modal -->
<!-- Modal Tambah-->

{{-- Edit Lembur --}}

@endsection

@push('customjs')
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@endpush

@push('customscripts')
<script src="{{asset('customjs/backend/lembur.js')}}"></script>
@endpush