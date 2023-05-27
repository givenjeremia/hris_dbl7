///////////// hapus data /////////
function formatRupiah(number) {
    return number.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
  }



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
                url: '/backend/laporangaji/' + kode,
                data: {
                    '_token': $('input[name=_token]').val(),
                },
                success: function () {
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    getData()
                }
            });
        }
    })
    }
    // window.hapusdata = hapusdata;
    ///////////// change name /////////
    // Get Data
    function getData(){

        var url2 = "/backend/laporangajiAjax";
        $.ajax(url2, // request url
        {
            
            dataType: 'json', // type of response data   // timeout milliseconds
            success: function (data,status,xhr) {   // success callback function
                //   alert(data);
    
      
                  $('#table-laporan').html(data.msg);
                  $('#list-data').DataTable();
                //   alert(data);
                // GetDetail();
                },
        });
    }
    getData()
   
    
    // Get Detail


    // 

    
    $('#btncari').on('click', function() {
        var sort_by = $('#sort_by').val();
        var url = "datalist-lg-month/"+sort_by;
        $.ajax(url, // request url
            {
            
                dataType: 'json', // type of response data // timeout milliseconds
                success: function (data,status,xhr) {   // success callback function
                    
              $('#table-laporan').html("");
              $('#table-laporan').html(data.msg);
            //   GetDetail();
                    
                    // alert(data);
                
                },
        });
   
    });

    $('#btnhitungperhitungangaji').on('click', function() {
        var url = "perhitunganGajiAjax";
        $.ajax(url, // request url
            {
            
                dataType: 'json', // type of response data
                success: function (data,status,xhr) {   // success callback function
                
                    if(data.status === 'oke'){
                        $('#table-laporan').html("");
                        $('#table-laporan').html(data.msg);
                        Swal.fire({
                            target: document.getElementById('table-laporan'),
                            title: "Success",
                            text: "Berhasil Generate Gaji",
                            type: 'success',
                            showConfirmButton: false,
                            timer: 2000,
                       });
                        // GetDetail();
                    }
                    else{
                        // alert(data.msg)
                        Swal.fire({
                            target: document.getElementById('table-laporan'),
                            title: "Error",
                            text: data.msg,
                            type: 'error',
                            showConfirmButton: false,
                            timer: 2000,
                       });
                    }
              
                    
                    // alert(data);
                
                },
        });
   
    });

    