<form method="POST" onsubmit="return validasiinput();" role="form" enctype="multipart/form-data"
action="{{url('/backend/tunjangankeahlian/'.$tk[0]->id)}}">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Tunjangan Keahlian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @csrf
    @method('put')
    <div class="modal-body">
        <div class="form-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Jumlah</label>


                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Rp</div>
                    </div>
                    <input type="number" class="form-control" value="{{ $tk[0]->data }}" name="jumlah" required>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Role</label>
                <select name="role" id="" class="form-control" required>
        
                    @foreach($divisi as $row)
                    <option value="{{$row->id}}" {{ $row->id == $tk[0]->role ? 'selected' : '' }}>{{$row->nama}}</option>
                    @endforeach
                </select>
            </div>
        </div>


    </div>
    
    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
</form>