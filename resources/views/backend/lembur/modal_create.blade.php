<!-- Modal Tambah-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" onsubmit="return validasiinput();" role="form" enctype="multipart/form-data"
                        action="{{url('/backend/lembur')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Lembur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Pegawai</label>
                        <select name="pegawai" class="form-control">
                            @foreach ($pegawai as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">Lama Lembur (Jam)</label>
                        <input type="number" class="form-control" name="lama_lembur" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Keterangan</label>
                        <textarea name="keterangan" class="form-control"  required></textarea>
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