<div class="modal-header">
    <h5 class="modal-title" id="exampleModalScrollableTitle">Pegawai Terlambat</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
 
    @foreach ($data as $item)
    <h5 class="text-bold"> Nama Pegawai : {{$item->id_pegawai}}</h5>
    <h6> Nama Kantor : {{ $item->id_client}}</h6>
    <p> Jam Masuk : {{$item->masuk}}</p>
    <hr>
    @endforeach
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
</div>