
$(function () {
    $('#list-data').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "desc"]],
        ajax: '/backend/data-client',
        columns: [
            {
                data: 'id', render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'nama', name: 'nama' },
            { data: 'alamat', name: 'alamat' },
            { data: 'email', name: 'email' },
            // { data: 'lokasi', name: 'lokasi' },
            {
                render: function (data, type, row) {
                    return '<a href="https://www.google.com/maps?q='+row['lat']+','+row['long']+'" class="btn btn-success" target="_blank">'+row['lokasi']+'</a>'
                },
                "className": 'text-center',
                "orderable": false,
                "data": null,
            },
            // { data: 'lat', name: 'lat' },
            // { data: 'long', name: 'long' },
            {
                render: function (data, type, row) {
                    return '<a href="/backend/client/' + row['id'] + '/edit" class="btn btn-success"><i class="fa fa-wrench"></i></a>'+
                    ' <button class="btn btn-danger" onclick="hapusdata(' + row['id'] + ')"><i class="fa fa-trash"></i></button>' +
                    '<button onclick="data_kontrak(' + row['id'] + ')"class="btn btn-info"><i class="fa fa-book"></i></button>'
                },
                "className": 'text-center',
                "orderable": false,
                "data": null,
            },
        ],
        pageLength: 10,
        lengthMenu: [[5, 10, 20], [5, 10, 20]]
    });

});

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
                url: '/backend/client/' + kode,
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


function data_kontrak(id) {
    $.ajax({
        type:'GET',
        url:'/backend/client/show-modal-kontrak/'+id,
        success: function(data){
            $('#modal-div').html("")

           $('#modal-div').html(data.msg)
        }
    });
}

function showTambahKontrak(id){
    $.ajax({
        type:'GET',
        url:'/backend/client/show-modal-tambah-kontrak/'+id,
        success: function(data){
            // $('#modalIndexKontrak').modal('hide');
            $('#modal-div').html("")
           $('#modal-div').html(data.msg)
        }
    });
}

$('#inputNamaClient').on('keyup', function(){
    var value = $(this).val();
    $.ajax({
        type:'POST',
        url:'/backend/client/cek-nama',
        data:{
            '_token':$('#data-page-client').val(),
              'value':value
             },
        success: function(data){
            if(data.status =='ada'){
                $('#validasi').html('<div class="text-danger">Nama Client Sudah Ada</div>')
                $('#btnTambahClient').prop('disabled', true);
            }
            else{
                $('#btnTambahClient').prop('disabled', false);
                $('#validasi').html('<div class="text-success">Nama Client Ready</div>')
            }
        }
    });
})