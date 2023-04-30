@extends('layouts/base')
@section('token')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('customcss')
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="content-header">
    <div class="container">
        <div class="row mb-2">

            <div class="col-sm-12">
                <h1 class="m-0 text-dark"> Dashboard</h1>
                <span>You are loggin as {{Auth::user()->level}}</span>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            @if (session('status'))
            <div class="col-sm-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>Info!</h4>
                    {{ session('status') }}
                </div>
            </div>
            @endif
            <div class="col-lg-12">
                <div class="small-box bg-yellow">
                    <div class="container">
                        <div id="accordion">
                            <div class="panel box box-primary">
                                <div class="box-header with-border">
                                    <h4 class="box-title p-1">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                            aria-expanded="false" class="collapsed">
                                   
                                            <h4 class=" text-dark text-bold">
                                                Shortcut
                                            </h4>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false"
                                    style="height: 0px;">
                                    <div class="box-body">
                                        <div class="box">
                                            <div class="box-body">
                                                <a class="btn btn-app" onclick="generateGaji()">
                                                    <i class="fa fa-money"></i> Generate Gaji
                                                </a>
                                                <a class="btn btn-app" onclick="inputjadwal()">
                                                    <i class="fa fa-tasks"></i> Add Shift
                                                </a>
                                                <a href="{{url('/backend/pegawai/create')}}" class="btn btn-app">
                                                    <i class="fa fa-users"></i> Add Pegawai
                                                </a>
                                                <a  href="{{url('/backend/client/create')}}" class="btn btn-app">
                                                    <i class="fa fa-building"></i> Add Client
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-12">
                <div class="small-box bg-teal">
                    <div class="container">
                        <div id="accordion_2">
                            <div class="panel box box-primary">
                                <div class="box-header with-border">
                                    <h4 class="box-title p-1">
                                        <a data-toggle="collapse" data-parent="#accordion_2" href="#collapseTwo"
                                            aria-expanded="false" class="collapsed" >
                                            <h4 class=" text-dark text-bold">

                                                Jadwal Shift Hari Ini
                                            </h4>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false"
                                    style="height: 0px;">
                                    <div class="table-responsive">
                                        <table id="list-data" class="table table-bordered table-striped">
                                            <thead>
                                                {{-- nama pegawai, judul, keterangan, tgl mulai, tgl akhir, status --}}
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Type</th>
                                                    <th>Shif</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($jadwal_shift_today as $key => $item)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $item['tanggal']}}</td>
                                                    <td>{{ $item['type_ket'] }} ({{ $item['type_name'] }})</td>
                                                    <td>{{ $item['nama_shift']}}</td>
                                                    <td>{{ $item['keterangan']}}</td>


                                                </tr>
                                    
                                                @endforeach   
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Type</th>
                                                    <th>Shif</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            {{-- <div class="col-lg-12">
                <div class="jumbotron jumbotron-fluid pr-4 pl-4">
                    <div class="container">
                        <h1 class="display-4">Welcome To The Dashboard</h1>
                        <p class="lead">This boiler is use <a href="https://adminlte.io" target="blank()">adminLTE</a>
                            for backend template.</p>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-lg-12">
                <div class="small-box bg-gradient-pink">
                    <div class="container p-lg-2">

                        <div class="row ">
                            <div class="col-lg-4 col-xs-6">
                                <div>
                                    <canvas id="myChartUmur"></canvas>
                                </div>
                            </div>

                            <div class="col-lg-4 col-xs-6">


                                <div>
                                    <canvas id="myChartDivisi"></canvas>
                                </div>

                            </div>

                            <div class="col-lg-4 col-xs-6">

                                <div>
                                    <canvas id="myChartJabatan"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-lg-12">
                <div class="small-box bg-gradient-yellow">
                    <div class="container">
                        <div>
                            <canvas id="myChartPenambahanKaryawan"></canvas>
                        </div>
                    </div>
                </div>

            </div> --}}

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4 col-xs-6">

                        <div class="small-box bg-dark">
                            <div class="inner">
                                <h3>{{ $cuti_pending }}</h3>
                                <p>Pemohonan Cuti Tertunda</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-edit"></i>
                            </div>
                            <a href="{{url('backend/permohonan-cuti')}}" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-xs-6">

                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{ $lembur_pending }}</h3>
                                <p>Pemohonan Lembur Tertunda</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-edit"></i>
                            </div>

                            <a href="{{url('backend/permohonan-lembur')}}" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-xs-6">

                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $count_pegawai_terlambat }}</h3>
                                <p>Pegawai Telat Hari Ini</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user-times"></i>
                            </div>
                            <a data-toggle="modal" data-target="#exampleModalScrollable"  href="#" onclick="showDetailPegawaiTelat()" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    {{-- <div class="col-lg-3 col-xs-6">

                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>65</h3>
                                <p>Unique Visitors</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog " id="modal-dialog" role="document">
      <div class="modal-content" id="modalContent">
       
      </div>
    </div>
  </div>
@endsection

@push('customjs')
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@endpush

@push('customscripts')
<script src="{{asset('customjs/backend/dashboard.js')}}"></script>
@endpush