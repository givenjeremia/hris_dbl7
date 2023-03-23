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
    var url = "/backend/datalist-lg";
    let rupiah = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    });
    $.ajax(url, // request url
        {
        
            dataType: 'json', // type of response data
            timeout: 500,     // timeout milliseconds
            success: function (data,status,xhr) {   // success callback function
                data.data.forEach(element => {

                    $('#list-data').DataTable();
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
            
            },
    });