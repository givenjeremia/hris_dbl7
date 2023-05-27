
$(function () {
    // $('#list-data').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     order: [[0, "desc"]],
    //     ajax: '/backend/datalist-lembur',
    //     columns: [
    //         {
    //             data: 'id', render: function (data, type, row, meta) {
    //                 return meta.row + meta.settings._iDisplayStart + 1;
    //             }
    //         },
    //         { data: 'nama', name: 'nama' },
    //         { data: 'keterangan', name: 'keterangan' },
    //         { data: 'tanggal', name: 'tanggal' },           
    //         { data: 'start_time', name: 'start_time' },
    //         { data: 'end_time', name: 'end_time' },
    //         { data: 'status', name: 'status', },
    //         {
    //             render: function (data, type, row) {
    //                 return '</a> <button class="btn btn-danger" onclick="hapusdata(' + row['id'] + ')"><i class="fa fa-trash"></i></button>'
    //             },
    //             "className": 'text-center',
    //             "orderable": false,
    //             "data": null,
    //         },
    //     ],
    //     pageLength: 10,
    //     lengthMenu: [[5, 10, 20], [5, 10, 20]]
    // });

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
                url: '/backend/lembur/' + kode,
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

$(function () {
    // $('#list-dataP').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     order: [[0, "desc"]],
    //     ajax: '/backend/datalist-lemburP',
    //     columns: [
    //         {
    //             data: 'id', render: function (data, type, row, meta) {
    //                 return meta.row + meta.settings._iDisplayStart + 1;
    //             }
    //         },
    //         { data: 'nama', name: 'nama' },
    //         { data: 'keterangan', name: 'keterangan' },
    //         { data: 'tanggal', name: 'tanggal' },           
    //         { data: 'start_time', name: 'start_time' },
    //         { data: 'end_time', name: 'end_time' },
    //         {
    //             render: function (data, type, row) {
    //                 return '<a href="/backend/lembur-action/' + row['id'] + '/diterima" class="btn btn-success"><i class="fa fa-check"></i></a> <a href="/backend/lembur-action/' + row['id'] + '/ditolak" class="btn btn-danger"><i class="fa fa-trash"></i></a>'
    //             },
    //             "className": 'text-center',
    //             "orderable": false,
    //             "data": null,
    //         },
    //     ],
    //     pageLength: 10,
    //     lengthMenu: [[5, 10, 20], [5, 10, 20]]
    // });

});