<div class="col-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Gaji Karyawan </h3>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="list-data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Date</th>
                            <th>Gaji Bersih</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan Keahlian</th>
                            <th>Tunjangan Lama Berkerja</th>
                            <th>Potongan Bpjs</th>
                            <th>Potongan Gaji</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
          
                @foreach ($data as $key => $row)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td id="nama_{{$row->id}}"></td>
                        @php
                            $dates=strtotime($row->created_at);
                            $date = date('Y-m-d',$dates);
                        @endphp
                        <td>{{$date}}</td>
                        <td id="bersih_{{$row->id}}"></td>
                        <td id="umk_{{$row->id}}"></td>
                        <td id="tk_{{$row->id}}"></td>
                        <td id="tlb_{{$row->id}}"></td>
                        <td id="bpjs_{{$row->id}}"></td>
                        <td id="potongan_{{$row->id}}"></td>
                        <td><button class="btn btn-danger" onclick="hapusdata({{$row->id}})"><i class="fa fa-trash"></i></button></td>
                    </tr>
                @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Date</th>
                            <th>Gaji Bersih</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan Keahlian</th>
                            <th>Tunjangan Lama Berkerja</th>
                            <th>Potongan Bpjs</th>
                            <th>Potongan Gaji</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>