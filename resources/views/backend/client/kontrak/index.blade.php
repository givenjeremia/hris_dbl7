<div class="modal fade" id="modalIndexKontrak" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="modalContent">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Kontrak {{ $client->nama }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="data-kontrak" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kontrak as $key => $row)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ date("j F Y", strtotime($row->tanggal_mulai)) }}</td>
                                <td>{{ date("j F Y", strtotime($row->tanggal_akhir)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                               <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Akhir</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>


            </div>

            <div class="modal-footer">
                <button id="tambahKontrak" onclick="showTambahKontrak({{$client->id}})" class="btn btn-success">Tambah Kontrak</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#modalIndexKontrak').modal('show');
        $('#data-kontrak').dataTable();
        $('#tambahKontrak').on('click', function() {
            $('#modalIndexKontrak').modal('hide');
        })
    });

</script>
