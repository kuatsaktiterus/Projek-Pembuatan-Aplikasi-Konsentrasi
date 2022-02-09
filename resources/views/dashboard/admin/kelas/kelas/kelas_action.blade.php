<div class="modal fade" id="editDataKelas" tabindex="-1" role="dialog" aria-labelledby="editDataKelas" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="editDataKelas">Edit Data Kelas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="{{ route('kelas.update', ['kela' => Crypt::encrypt($data->id)]) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="kelas" class="col-form-label">Kelas</label>
                <input type="text" class="form-control" id="kelas" name="nama_kelas" placeholder="Kelas A" value="{{ $data->kelas }}">
            </div>
            <div class="form-group">
                <label for="status" class="col-form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" placeholder="Status" value="{{ $data->status }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
                </div>
        </form>
        </div>

    </div>
    </div>
</div>
<script>
    $("#editDataKelas").modal('show');
</script>