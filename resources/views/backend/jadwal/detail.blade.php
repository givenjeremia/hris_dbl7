<div class="modal-header">
    <h5 class="modal-title" id="exampleModalScrollableTitle">{{ strtoupper($title) }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
 
    @foreach ($detail_shift as $item)
    <div class="row justify-content-between">
        <div class="col-10">
            <h5>{{$item['type_name']}}</h5>
            <h6 class=" text-bold ">{{ $item['nama_shift']}}</h6>
            <p> Keterangan : {{ empty($item['keterangan']) ? 'Tidak Ada Keterangan' : $item['keterangan'] }}</p>
        </div>
        <div class="col-2">
            <p></p>
            <button class="btn btn-danger" onclick="hapusdata({{$item['id_jadwal_shift']}})"><i class="fa fa-trash"></i></button>
            <p></p>
        </div>
    </div>
    <hr>
    @endforeach
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>