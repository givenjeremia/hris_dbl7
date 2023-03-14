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
                <h1 class="m-0 text-dark"> Jadwal</h1>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
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
                        <h3 class="card-title">Data Jadwal shift Bulan {{ $bulan_sekarang }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-default btn-sm" onclick="inputjadwal()"><i
                                    class="fas fa-plus"></i> Tambah
                                Data
                            </button>

                        </div>
                    </div>
                    <div class="card-body">
                        <p id="test"></p>
                        <div class="table-responsive">

                            <table id="list-data" class="table table-bordered table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        {{-- <th scope="col">Nama</th> --}}
                                        {{-- <th scope="col">date range</th> --}}
                                        <th scope="col">type</th>
                                        @for ($i = 1; $i <= count($date_1_month); $i++) <th scope="col" id="shift">
                                            {{$i}}</th>
                                            @endfor
                                            {{-- <th scope="col" class="text-center">Aksi</th> --}}


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $row)
                                    <tr>
                                        <th scope="row">1</th>
                                        {{-- <td id="{{$row->type}}_{{$row->Ids}}_{{$row->id}}">{{$row->Ids}}</td> --}}
                                        {{-- <td>
                                            <div class="d-flex align-items-center">
                                                <div class="ms-3">

                                                    <p class=" mb-1">{{$row->tanggal}} </p>
                                                    <p class="mx-5"></p>
                                                </div>
                                            </div>
                                        </td> --}}
                                        <td>{{$row->type}}</td>
                                        @for ($i = 0; $i < count($date_1_month); $i++) @php
                                            $tanggal=explode("-",$date_1_month[$i][0])[2]; @endphp 
                                            @if($tanggal==str_pad($i+1, 2, "0" , STR_PAD_LEFT)) 
                                            @if (count($date_1_month[$i])> 1)
                                            @php
                                            // dd($date_1_month[$i][1])
                                            $count = 0;
                                            foreach ($date_1_month[$i][1] as $item) {
                        
                                            if($item['type'] == $row->type){
                                            $count++;
                                            }
                                
                                            }
                                            @endphp

                                            @if ($count != 0)
                                                
                                            <td style="background-color:yellow;">
                                                <a href="#" data-toggle="modal" data-target="#exampleModalScrollable" onclick="showDetail('{{$row->type}}','{{$date_1_month[$i][0]}}')">{{ $count }}</a>

                                            </td>
                                            @else
                                                
                                            <td>0</td>
                                            @endif



                                            @else
                                            <td>0</td>


                                            @endif



                                            @endif


                                            {{-- <td id="shift_{{$row->$i}}_{{$i}}_{{$row->id}}"
                                                style="font-size: 14px">{{$row->$i}}</td> --}}
                                            @endfor
                                            {{-- <td><button class="btn btn-danger" onclick="hapusdata({{$row->id}})"><i
                                                        class="fa fa-trash"></i></button></td> --}}
                                    </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">No</th>
                                        {{-- <th scope="col">Nama</th> --}}
                                        {{-- <th scope="col">date range</th> --}}
                                        <th scope="col">type</th>
                                        {{-- @for ($i = 1; $i < 32; $i++) <th id="shift">{{$i}}</th>
                                            @endfor --}}
                                            {{-- <th scope="col" class="text-center">Aksi</th> --}}


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
<!-- Button trigger modal -->
  <!-- Modal -->
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
<script src="{{asset('customjs/backend/jadwal.js')}}"></script>
@endpush