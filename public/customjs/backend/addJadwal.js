

///////////////// format table ////////////
$(document).ready(function () {
    var table = $('#list-data').DataTable({
        columnDefs: [
            {
                orderable: false,
                targets: [1, 2, 3],
            },
        ],
    });
});

///////////////// ajax input value ////////////
        var bulan = document.getElementById('bulan').textContent;
        var tahun = new Date().getFullYear();
        var type = document.getElementById('type').textContent;
        var ID = document.getElementById('pegawai').textContent;   
        const tanggal = document.querySelectorAll("#tanggal");
        var url_base = "https://hrissistem.com/";
        var time = new Date().getTime();

//             $('#SubmitBtn').click(function () {
//                 $.ajaxSetup({
//                     headers: {
//                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                     }
//                 });
//                 dataslug={
//                 tahun:tahun,
//                 bulan:bulan,
//                 ID:ID,
//                 time:time,
//                 type:type,
//                 slugC:true,
//                 _token: "{{ csrf_token() }}", 
//                 }
//                 $.ajax({
//                             url: '/backend/jadwal',
//                             type:"POST",
//                             dataType: 'json',
//                             data:dataslug
//                         });
//                         const url ='/backend/slug-id/'+bulan+'/'+ tahun+'/'+ type+'/'+time+''
                    
//                         var data = $('select').serialize();
//                         $.ajax(url, // request url
//     {
//         success: function (data, status, xhr) {// success callback function 
//             const id = data.id
//             tanggal.forEach(function(i, idx, array){
//                 const tanggal = i.textContent;
//                 const select = $('#'+tanggal+'select').val();
//                 const keterangan = $('#'+tanggal+'').text();  
//                 const urut = idx +1;
//                 const slug = id;
//             datapush = {
//             tanggal:tanggal,
//             shift:select,
//             keterangan:keterangan,
//             bulan:bulan,
//             ID:ID,
//             urut:urut,
//             type:type,
//             slug:slug,
//             _token: "{{ csrf_token() }}",    
//         }
//                 $.ajax({
//                 url: '/backend/jadwal',
//                 type:"POST",
//                 dataType: 'json',
//                 data:datapush
//             });

//             // return finnis loop
//             const long =(array.length -1) 
//             if(idx >= long ){
               
//             } 

//             }); 
            
//     }
// });

           
           
//             return false;
//         });
//////////////////// Api Tanggal Merah /////////////////// 
var data = document.getElementById('bulan').textContent;
    var url = "https://api-harilibur.vercel.app/api?month="+ data+"";
$.ajax(url, // request url
    {
        success: function (data, status, xhr) {// success callback function
            data.forEach(element => {
                if (element.is_national_holiday){
                const dates =element.holiday_date 
                const data = element.holiday_name
                const [ year, month, day] = dates.split('-');
                const d = String(day).padStart(2, '0');
                const date = ''+year+'-'+month+'-'+d+''
                $('#'+date+'').html(data)
                }
                ;
            });    
    }
});
