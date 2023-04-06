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

{{-- <script src="{{asset('customjs/backend/lg.js')}}"></script> --}}
<script>
    ///////////// hapus data /////////




function hapusdata(kode) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: true
    })
    swalWithBootstrapButtons.fire({
        title: 'Hapus Data ?',
        text: "Data tidak dapat di pulihkan kembali!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Tidak',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'DELETE',
                url: '/backend/jadwal/' + kode,
                data: {
                    '_token': $('input[name=_token]').val(),
                },
                success: function () {
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    $('#list-data').DataTable().ajax.reload();
                }
            });
        }
    })
    }
    window.hapusdata = hapusdata;
    ///////////// change name /////////
    // Get Data
    var url2 = "/backend/laporangajiAjax";
    $.ajax(url2, // request url
    {
        
        dataType: 'json', // type of response data
        timeout: 500,     // timeout milliseconds
        success: function (data,status,xhr) {   // success callback function
            //   alert(data);

  
              $('#table-laporan').html(data.msg);
            //   alert(data);
            GetDetail();
            },
    });
   
    
    // Get Detail
    function GetDetail() {
        var url = "/backend/datalist-lg";
        let rupiah = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
        });
        $.ajax(url, // request url
            {
            
                dataType: 'json', // type of response data
                timeout: 500,     // timeout milliseconds
                success: function (data,status,xhr) { 
                  // success callback function
                    data.data.forEach(element => {
    
                 
                        if(element.nama_pg ==='UMK'){
                            var id = element.id
                            var datas= element.data_pg
                            var data =`${rupiah.format(datas)}`
                            $('#umk_'+id+'').html(data)  
                        }
                        else if(element.nama_pg ==='tunjangan keahlian'){
                            var id = element.id
                            var datas= element.data_pg
                            var data =`${rupiah.format(datas)}`
                            $('#tk_'+id+'').html(data)  
                        }
                        else if(element.nama_pg ==='tunjangan lama berkerja'){
                            var id = element.id
                            var datas= element.data_pg
                            var data =`${rupiah.format(datas)}`
                            $('#tlb_'+id+'').html(data)  
                        }
                    });  
                    data.data.forEach(elements => {
                if(elements.nama_pgs ==='bpjs'){
                    var id = elements.id
                    var datas= elements.data_pgs
                    var data =`${rupiah.format(datas)}`
                    $('#bpjs_'+id+'').html(data)  
                }
                else if(elements.nama_pgs ==='potongan gaji'){
                    var id = elements.id
                    var datas= elements.data_pgs
                    var data =`${rupiah.format(datas)}`
                    $('#potongan_'+id+'').html(data)  
                }
                    });  
                    data.data.forEach(row => {
                        // alert(row.nominal);
                        if(row.nominal){
                            var id = row.id
                            var datas= row.nominal
                            var data =`${rupiah.format(datas)}`
                            $('#bersih_'+id+'').html(data)  
                        }
                    });
                    data.data.forEach(rows => {
                        if(rows.nama_pegawai){
                            var id = rows.id
                            var data= rows.nama_pegawai
                            $('#nama_'+id+'').html(data)  
                        }
                            });  

                    $('#list-data').DataTable();
                
                },
        });
    
    }
   

    // 

    
    $('#btncari').on('click', function() {
        var sort_by = $('#sort_by').val();
        var url = "datalist-lg-month/"+sort_by;
        $.ajax(url, // request url
            {
            
                dataType: 'json', // type of response data
                timeout: 500,     // timeout milliseconds
                success: function (data,status,xhr) {   // success callback function
                    
              $('#table-laporan').html("");
              $('#table-laporan').html(data.msg);
              GetDetail();
                    
                    // alert(data);
                
                },
        });
   
    });

    $('#btnhitungperhitungangaji').on('click', function() {
        var url = "perhitunganGajiAjax";
        $.ajax(url, // request url
            {
            
                dataType: 'json', // type of response data
                timeout: 500,     // timeout milliseconds
                success: function (data,status,xhr) {   // success callback function
                
                    if(data.status === 'oke'){
                        $('#table-laporan').html("");
                        $('#table-laporan').html(data.msg);
                        GetDetail();
                    }
                    else{
                        alert(data.msg)
                    }
              
                    
                    // alert(data);
                
                },
        });
   
    });

    
</script>
@endsection