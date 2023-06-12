<div class="modal fade" id="modalTambahKontrak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" onsubmit="return validasiinput();" role="form" enctype="multipart/form-data"
                        action="{{url('/backend/client/tambah-kontrak')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kontrak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="data_client" value="{{ $client->id }}">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Kontrak</label>
                        <input type="text" class="form-control" name="nama" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="tanggal_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="tanggaL_akhir" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#modalTambahKontrak').modal('show');
    });

</script>