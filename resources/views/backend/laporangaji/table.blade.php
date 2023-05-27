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
                        <th>Tanggal</th>
                        <th>Gaji Bersih</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan Keahlian</th>
                        <th>Tunjangan Lama Berkerja</th>
                        <th>Lembur</th>
                        <th>Potongan Bpjs</th>
                        <th>Potongan Gaji</th>
                        <th>Status Pembayaran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                @if (empty($gaji))
                <tbody>
                    <tr>
                        <td colspan="10">
                            <h4 class=" text-center">GAJI BELUM DI GENERATE</h4>
                        </td>
                    </tr>
                </tbody>
                @else
                <tbody>
                    @foreach ($gaji as $key => $row)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $row['nama_pegawai'] }}</td>
                        <td>{{ date("j F Y", strtotime($row['tanggal'])) }}</td>
                        <td>Rp. {{ number_format($row['gaji_bersih']) }}</td>
                        <td>Rp. {{ number_format($row['gaji_pokok']) }}</td>
                        <td>Rp. {{ number_format($row['tunjangan_keahlian']) }}</td>
                        <td>Rp. {{ number_format($row['tunjangan_lama_bekerja']) }}</td>
                        <td>Rp. {{ number_format($row['lembur']) }}</td>
                        <td>Rp. {{ number_format($row['potongan_bpjs']) }}</td>
                        <td>Rp. {{ number_format($row['potongan_gaji']) }}</td>
                        <td>{{ number_format($row['status_pembayaran']) ? 'Sudah Dibayar' : 'Belum Dibayar' }}</td>
                        <td><button class="btn btn-danger" onclick="hapusdata({{$row['id_pendapatan']}})"><i
                                    class="fa fa-trash"></i></button></td>
                    </tr>
                    @endforeach
                </tbody>
                @endif
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Tanggal</th>
                        <th>Gaji Bersih</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan Keahlian</th>
                        <th>Tunjangan Lama Berkerja</th>
                        <th>Lembur</th>
                        <th>Potongan Bpjs</th>
                        <th>Potongan Gaji</th>
                        <th>Status Pembayaran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>