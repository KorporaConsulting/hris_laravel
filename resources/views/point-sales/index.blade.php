@extends('layouts.app')

@section('head')
@endsection


@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Sistem Point Sales</h4>
            </div>
            <div class="card-body">

                <button class="btn btn-primary add-point-button mb-3">
                    Ajukan Point
                </button>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">
                                #
                            </th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Point</th>
                            <th>Approved</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($points as $key => $data)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ $data->user->name }}
                                </td>
                                <td>
                                    {{ $data->deskripsi }}
                                </td>
                                <td>
                                    {{ $data->point }}
                                </td>
                                <td>
                                    {{ $data->approved != 0 ? 'Disetujui' : 'Belum Disetujui' }}
                                </td>
                                <td>

                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary detail-point-btn">Detail</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal add-point-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajukan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('point-sales.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" name="deskripsi" id="deskripsi" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="files">File</label>
                            <input type="file" name="files[]" id="files" class="form-control" multiple required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        $(".table").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [2, 3]
            }]
        });

        $(".add-point-button").on('click', function() {
            $(".add-point-modal").modal('show');
        })
    </script>
@endpush
