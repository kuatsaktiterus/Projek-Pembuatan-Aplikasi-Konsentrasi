
    <div class="main-content">
        <section class="section">
            <div class="card" style="width:100%;">
                <div class="card-body">
                    <h2 class="card-title" style="color: black;">Admin</h2>
                    <hr>
                    <button class="btn btn-success" data-toggle="modal" data-target="#tambahModal" data-whatever="@mdo">Tambah
                        Data Admin</button>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                            <div class="table-responsive">
                            {!! $dataTable->table() !!}
                            </div>
                        </div>
                    </div>
                    {!! $dataTable->scripts() !!}    
                </div>
            </div>
        </section>
    </div>
