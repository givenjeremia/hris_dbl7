function inputjadwal() {
    //  get data
    let url = "";
    let data = $.getJSON("/backend/list-add-jadwal", function (resource) {
        // data date
        const month = [
            { bulan: "January", id: String(1).padStart(2, "0") },
            { bulan: "February", id: String(2).padStart(2, "0") },
            { bulan: "March", id: String(3).padStart(2, "0") },
            { bulan: "April", id: String(4).padStart(2, "0") },
            { bulan: "May", id: String(5).padStart(2, "0") },
            { bulan: "June", id: String(6).padStart(2, "0") },
            { bulan: "July", id: String(7).padStart(2, "0") },
            { bulan: "August", id: String(8).padStart(2, "0") },
            { bulan: "September", id: String(9).padStart(2, "0") },
            { bulan: "October", id: 10 },
            { bulan: "November", id: 11 },
            { bulan: "December", id: 12 },
        ];
        // looping data
        let category = ["Devisi", "Jabatan", "Pegawai"];
        const jabatans = resource.data.jabatan;
        const pegawai = resource.data.pegawai;
        const devisi = resource.data.devisi;
        var options_jabatan = {};
        var options_devisi = {};
        var options_pegawai = {};
        var options_category = {};
        var options_mount = {};

        $.map(jabatans, function (o) {
            options_jabatan[o.id] = [o.nama];
        });
        $.map(category, function (o) {
            options_category[o] = [o];
        });
        $.map(pegawai, function (o) {
            options_pegawai[o.id] = [o.nama];
        });
        $.map(devisi, function (o) {
            options_devisi[o.id] = [o.nama];
        });
        $.map(month, function (o) {
            options_mount[o.id] = [o.bulan];
        });
        (async () => {
            const steps = ["1", "2", "3", "4"];
            const Queue = Swal.mixin({
                progressSteps: steps,
                confirmButtonText: "Next",
            });
            // Sweet alert category

            const { value: categorys } = await Queue.fire({
                title: "Pilih Kategori ",
                input: "select",
                inputOptions: options_category,
                inputValue: "1",
                confirmButtonText: "Next",
                showCancelButton: true,
                currentProgressStep: 0,
                showClass: { backdrop: "swal2-noanimation" },
            });
            // category devisi
            if (categorys == category[0]) {
                const { value: id } = await Queue.fire({
                    title: "Select Devisi",
                    input: "select",
                    inputOptions: options_devisi,
                    inputValue: "1",
                    confirmButtonText: "Next",
                    showCancelButton: true,
                    currentProgressStep: 1,
                    showClass: { backdrop: "swal2-noanimation" },
                });
                function getId() {
                    return id;
                }
            }
            ////////////////////////////////////////////
            /////////// category jabatan////////////////
            else if (categorys == category[1]) {
                const { value: id } = await Queue.fire({
                    title: "Select Jabatan",
                    input: "select",
                    inputOptions: options_jabatan,
                    inputValue: "1",
                    confirmButtonText: "Next",
                    showCancelButton: true,
                    currentProgressStep: 1,
                    showClass: { backdrop: "swal2-noanimation" },
                });
                function getId() {
                    return id;
                }
            }

            //////////////////////////////////////
            // category pegawai/////////////////
            else if (categorys == category[2]) {
                const { value: id } = await Queue.fire({
                    title: "Select Pegawai",
                    input: "select",
                    inputOptions: options_pegawai,
                    inputValue: "1",
                    confirmButtonText: "Next",
                    showCancelButton: true,
                    currentProgressStep: 1,
                });
                function getId() {
                    return id;
                }
            }
            ///////////////////////////////////
            const getid = getId();
            if (getid != null) {
                const { value: date_range } = await Queue.fire({
                    title: "Selected Date",
                    html:
                        '<div class="form-group">' +
                        '<label for="exampleInputEmail1">Date Start</label>' +
                        '<input type="date" class="form-control" id="date_start" name="date_start" required autofocus>' +
                        "</div>" +
                        '<div class="form-group">' +
                        '<label for="exampleInputEmail1">Date End</label>' +
                        '<input type="date" class="form-control" id="date_end" name="date_end" required>' +
                        "</div>",
                    confirmButtonText: "Next",
                    showCancelButton: true,
                    currentProgressStep: 2,
                    showClass: { backdrop: "swal2-noanimation" },
                    focusConfirm: false,
                    preConfirm: () => {
                        let date_start =
                            document.getElementById("date_start").value;
                        let date_end =
                            document.getElementById("date_end").value;

                        if (!date_start) {
                            alert("Date Start Cannot Be Null");
                            return false;
                        } else if (!date_end) {
                            alert("Date End Cannot Be Null");
                            return false;
                        } else {
                            return [date_start, date_end];
                        }
                    },
                });
                if (date_range) {
                    Swal.fire(JSON.stringify(date_range));
                }

                function getdates() {
                    return date_range;
                }

                await Queue.fire({
                    title: "Can You Send?",
                    confirmButtonText: "Send",
                    currentProgressStep: 3,
                    showCancelButton: true,

                    preConfirm: () => {
                        window.location.assign(
                            "" +
                                url +
                                "/backend/add-jadwal/" +
                                getId() +
                                "/" +
                                getdates() +
                                "/" +
                                categorys +
                                ""
                        );
                    },
                }).then(function () {
                    // window.location.assign(''+ url+'/backend/add-jadwal/'+ getId() +'/' + getKeterangan()+ '/' +getdates()+'/'+ categorys +'')
                });
            }
        })();
    });
}

function generateGaji() {
    var url = "perhitunganGajiAjax";
    $.ajax(
        url, // request url
        {
            dataType: "json", // type of response data
            success: function (data, status, xhr) {
                // success callback function

                if (data.status === "oke") {
                    alert("Gaji Bulan Ini Berhasil Di Generate")
                } else {
                    alert(data.msg);
                }

                // alert(data);
            },
        }
    );
}

function showDetailPegawaiTelat() {
    // alert(type+' '+tanggal+' ');
    var url = "/backend/detail-pegawai-terlambat";
    $.ajax(url, // request url
      {
     
          dataType: 'json', // type of response data
          // timeout: 500,     // timeout milliseconds
          success: function (data,status,xhr) {   // success callback function
            // alert(data.msg);
            $("#modalContent").html(data.msg);
            $("#modal-dialog").addClass("modal-dialog-scrollable");
            // data.data.forEach(element => {
            //   // alert(element.keterangan);
            //   // modalContent
            //   // var id = element.id
            //   // var nama = element.nama
            //   // var shift_id = element.id_shift
            // });  
           
          },
  });
  }
