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

                @role('staff')
                    <button class="btn btn-primary add-point-button mb-3">
                        Ajukan Point
                    </button>
                    <h5>Sisa Poin Anda : {{ $sisa_point }}</h5>
                @endrole


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
                                    @if ($data->is_approved == '1')
                                        <button class="btn btn-sm btn-success btn-block disabled">Disetujui</button>
                                    @elseif($data->is_approved == '0')
                                        <button class="btn btn-sm btn-danger btn-block disabled">Ditolak</button>
                                    @else
                                        <button class="btn btn-sm btn-secondary btn-block disabled">Belum</button>
                                    @endif
                                </td>
                                <td>
                                    @tanggal($data->created_at)
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary detail-point-button"
                                        data-id="{{ $data->id }}">Detail</button>
                                    <button class="btn btn-sm btn-danger delete-point-button"
                                        data-id="{{ $data->id }}">Delete</button>
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
    @role('staff')
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
    @endrole
    <div class="modal detail-point-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('point-sales.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <table class="h6">
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td id="nama"></td>
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td>:</td>
                                <td id="deskripsi"></td>
                            </tr>
                        </table>
                        <button type="button" class="btn btn-primary gambar-toggle mb-3">Gambar</button>

                        <div class="gambar-point row" style="display: none;">

                        </div>
                        @hasanyrole('manager|hrd')
                            <input type="hidden" name="approved_by" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="tanggal_approve" value="{{ date('Y-m-d') }}">
                            <div class="form-group">
                                <label for="">Poin</label>
                                <input type="number" name="point" class="form-control">
                            </div>
                        @endhasanyrole
                    </div>
                    @hasanyrole('manager|hrd')
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <input type="submit" name="status" value="Tolak" class="btn btn-danger">
                            <input type="submit" name="status" value="Setujui"class="btn btn-success">
                        </div>
                    @endhasanyrole
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
        });

        $('.detail-point-modal .gambar-toggle').on('click', function() {
            $('.detail-point-modal .gambar-point').toggle(300);
        });

        $(".detail-point-button").on('click', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = $(this).data('id');

            $.ajax({
                type: "POST",
                url: "{{ route('point-sales.edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {


                    $('.detail-point-modal').modal('show');
                    if (res.is_approved != null) {
                        $('.detail-point-modal .modal-footer').hide();
                        $('.detail-point-modal .form-group').hide();
                    }
                    $('.detail-point-modal input[name=id]').val(res.id);
                    $('.detail-point-modal #nama').html(res.user.name);
                    $('.detail-point-modal #deskripsi').html(res.deskripsi);
                    $('.detail-point-modal .gambar-point').html('');

                    var files = JSON.parse(res.files);
                    $.each(files.path, function(key, val) {
                        var imgsrc = "{{ asset('storage') }}" + '/' + val;
                        var CurrentImgSrc = imgsrc;
                        img = $('<img class="mb-1 w-100 col-12" >');
                        img.attr('src', CurrentImgSrc);
                        $('.detail-point-modal .gambar-point').append(img);
                    });

                }
            });
        });

        $('.delete-point-button').on('click', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = $(this).attr("data-id");
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Anda tidak akan bisa mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('point-sales.destroy') }}",
                        dataType: "JSON",
                        data: {
                            id: id
                        },
                        success: function() {
                            location.reload();
                        },
                        error: function() {
                            Swal.fire(
                                'Server Error', '', 'error'
                            );
                        }
                    })
                }
            })
        })
    </script>
@endpush
