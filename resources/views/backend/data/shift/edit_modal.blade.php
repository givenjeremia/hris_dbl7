<form method="POST" onsubmit="return validasiinput();" role="form" enctype="multipart/form-data"
    action="{{url('/backend/shift/'.$shift->id)}}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Shift</h5>
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
                <input type="text" class="form-control" name="nama" value="{{$shift->nama}}" required autofocus>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Jam Masuk</label>
                <input type="time" class="form-control" name="jam_masuk" value="{{$shift->jam_masuk}}" required>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Jam Pulang</label>
                <input type="time" class="form-control" name="jam_pulang" value="{{$shift->jam_pulang}}" required>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
</form>