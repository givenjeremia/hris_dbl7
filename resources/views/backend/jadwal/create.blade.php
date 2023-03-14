@extends('layouts/base')

{{-- @section('token')
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection --}}

@section('customcss')
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection

@section('content')
<div class="content-header">
    {{-- <div class="d-none" id='bulan'>{{$month}}</div> --}}
    <div class="d-none" id='pegawai'>{{$id}}</div>
    <div class="d-none" id='type'>{{$type}}</div>
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark"> Jadwal Shift</h1>
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
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">ADD SHIFT </h3>
                        
                    </div>
                    <div class="card-body">
                            <form method="POST" onsubmit="return validasiinput();" role="form" enctype="multipart/form-data"
                                    action="{{url('/backend/jadwal')}}">
                                    <input type="hidden" class="hidden" value="{{$id}}" name="Ids">
                                        {{-- <input type="text" class="hidden" value="{{$month}}" name="month"> --}}
                                        <input type="hidden" class="hidden" value="{{$type}}" name="type"> 
                        <div class="table-responsive">
                            
                            <table id="list-data" class="table table-bordered table-striped">
                                <thead>
                                        <th> Tanggal </th>
                                        <th>Shift </th>
                                        <th>Keterangan</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($date as $d)
                                    @php
                                    $dt = strtotime($d);
                                    $i = date('d',$dt);
                                    $id_nama =(int)$i;
                                   @endphp

                                    <tr>
                                        <div class="d-none">
                                        
                                        <input type="text" class="hidden" value="{{$d->toDateString()}}" name="input[{{$id_nama}}][date]">

                                        {{-- <input type="text" class="hidden" value="{{$start}}" name="date_start"> --}}
                                        {{-- <input type="text" class="hidden" value="{{$end}}" name="date_end"> --}}
                                        <td><p class="fs-5" id="tanggal">{{$d->toDateString()}}</p></td>
                                        
                                    </div>
                                      
                                    <td><select aria-label="Default select example" class="form-select " id="{{$d}}select" name="input[{{$id_nama}}][shift]">
                                        @foreach ($shift as $s)
                                        <option value={{$s->id}} >
                                            {{$s->nama}}
                                        </option>
                                        @endforeach
                                        {{-- <option value='libur' id="libur{{$d}}" >
                                            Libur
                                        </option> --}}
                                    </select></td>
                                    <td id={{$d}} class={{'text-secondary'}}>
                                    <textarea class="form-select "  name="input[{{$id_nama}}][keterangan]" id="{{$d}}keterangan"></textarea>
                                    </td>
                                    </tr>
                                @endforeach
                              
                                </tbody>
                                <tfoot>
                                
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Shift </th>
                                        <th>Keterangan</th>
                                    </tr>
                                </tfoot>
                                
                            </table>
                            <div class="d-grid gap-1">
                            <button type="submit" id="" class="btn btn-success "><i class="fas fa-plus"></i> 
                                Submit Data
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<script>

</script>
@endsection

@push('customjs')
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@endpush

@push('customscripts')
<script src="{{asset('customjs/backend/addJadwal.js')}}"></script>
@endpush