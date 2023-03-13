<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SLIP GAJI</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
      </head>
    <body>
    <style>
            .salary-slip{
        margin: 5px;
        border: 2px solid black;
            }
            .empDetail {
                width: 100%;
              }
              
                
                .head {
                  margin: 10px;
                  margin-bottom: 50px;
                  width: 100%;
                }
                
                .companyName {
                  text-align: left;
                  font-size: 25px;
                  font-weight: bold;
                }
                .companyName p {
                  margin-left: 18px;
                  font-size: 18px;
                  font-weight: lighter;
                }
                
                .salaryMonth {
                  text-align: center;
                }
                
                
                
                .table-border-right {
                  border-right: 1px solid;
                }
                
                .myBackground {
                  padding-top: 10px;
                  text-align: left;
                  border: 1px solid black;
                  height: 40px;
                  border-right: none;
                  border-left: none;
                }
                
                .myAlign {
                  text-align: center;
                  border-right: 1px solid black;
                }
                
                .myTotalBackground {
                  padding-top: 10px;
                  text-align: left;
                  background-color: #EBF1DE;
                  border-spacing: 0px;
                }
                
                .align-4 {
                  width: 25%;
                  float: left;
                }
                
                .tail {
                  margin-top: 35px;
                }
                
                .align-2 {
                  margin-top: 25px;
                  width: 50%;
                  float: left;
                }
                
                .border-center {
                  text-align: center;
                }

                
                th, td {
                  padding-left: 6px;
                }
              
                .nominal-total{
                  padding-right: 25px;
                  font-size: 18px;
                }
              .total-gaji{
                font-size: 21px;
                padding-left: 10px;
              }
              th span{
                margin-left: 5px; 
                color: rgba(0, 0, 0, 0.767)
                font-size: 18px;
              }
    </style>
        <div class="salary-slip" >
         

          <div class="container-fluid judul">
            <div class="row "style="background-color:#c2d69b ">
              <div class="col">
                <div class="companyName text-center">
                  Nama Perusahaan<br>
                  <p>Alamat</p>
                </div>
              </div>
            </div>
          </div>
            <table class="empDetail table table-borderless">
              <tr>
                <th>
                  Nama : <span>  {{$name}}</span>
      </th>
                <td>
                
      </td>
              </tr>
              <tr>
                <th>
                  Jabatan : <span> {{$jabatan}}</span>
      </th>
                <td>
                
      </td>
              
              </tr>
              <tr>
                <th>
                  Divisi : <span>{{$divisi}}</span>
      </th>
                <td>

      </td>
              
               

              </tr>
              <tr class="myBackground">
                <th colspan="2">
                  PENGHASILAN
      </th>
                <th></th>
                <th class="table-border-right">
                  Nominal(Rp)
      </th>
                <th colspan="2">
                  POTONGAN
      </th>
                <th >
                
      </th>
                <th >
                  Nominal(Rp)
      </th>
              </tr>
              @foreach ($pendapatan as $p)
                <tr>
                <th colspan="2">
                  {{$p->type}}
                </th>
                <td></td>
                <td class="myAlign">
                  {{"Rp " . number_format( $p->data,2,',','.')}}
                </td>
                <th colspan="2" >
                  @foreach ($p->potongan as $item)
                  {{$item->type}}
              @endforeach
                  </th >
                  <td></td>
                  
                  <td class="myAlign">
                  @foreach ($p->potongan as $item)
                  {{"Rp " . number_format( $item->data,2,',','.')}}
                  @endforeach
                </td>
               
          </tr >    
              @endforeach
              <tr class="myBackground">
                <th colspan="3">
                  Total Gaji Kotor
      </th>
                <td class="myAlign">
                  @php
                  foreach ($pendapatan as $p) {
                    $kotor[]=$p->data;
                  }
                  $gaji_kotor =array_sum($kotor);   
                  @endphp
                  {{"Rp " . number_format( $gaji_kotor,2,',','.')}}
      </td>
                <th colspan="3" >
                  Total Potongan
      </th >
                <td class="myAlign">
                  @php
                  foreach ($pendapatan as $p) {
                    foreach ($p->potongan as $item) {
                      $potongans[]=$item->data;
                    }
               
                  }
                  $potongan =array_sum($potongans);   
                  @endphp
                  {{"Rp " . number_format( $potongan,2,',','.')}}
      </td>
              </tr >
              <tr class="myBackground">
                <th colspan="7" class="total-gaji">
                 Gaji Bersih
      </th>
                <td class="nominal-total text-end">
                  {{"Rp " . number_format( $totalgaji,2,',','.')}}
      </td>
                </tr >
                
                </tbody>
            </table >

          </div >
     
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>