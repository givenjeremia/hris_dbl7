<form method="POST" onsubmit="return validasiinput();" role="form" enctype="multipart/form-data" action="{{url('/backend/divisi/'.$divisi->id)}}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Divisi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @csrf
    @method('put')
    <div class="modal-body">
        <div class="form-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Nama</label>
                <input type="text" class="form-control" name="nama" value="{{$divisi->nama}}"
                    required autofocus>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Tunjangan</label>
                <input type="number" class="form-control" name="tunjangan" value="{{$divisi->nominal_tunjangan}}"
                    required autofocus>
            </div>
        </div>


    </div>
    
    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
</form>