@extends('layouts.app')

@section('head')
@endsection


@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Penukaran Point Sales</h4>
            </div>
            <div class="card-body">

                @hasanyrole('hrd|manager')
                    <button class="btn btn-primary add-penukaran-button mb-3">
                        Penukaran Point
                    </button>
                @endhasanyrole

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">
                                #
                            </th>
                            <th>Nama</th>
                            <th>Reward</th>
                            <th>Point</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penukaran_points as $key => $data)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ $data->user->name }}
                                </td>
                                <td>
                                    {{ $data->reward }}
                                </td>
                                <td>
                                    {{ $data->pengurangan_point }}
                                </td>
                                <td>
                                    {{ $data->tanggal_penukaran }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-penukaran-button"
                                        data-id="{{ $data->id }}">Hapus</button>
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
    @role('hrd|manager')
        <div class="modal add-penukaran-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Penukaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('penukaran-point.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="approved_by" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="tanggal_penukaran" value="{{ date('Y-m-d') }}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="Karyawan">Karyawan</label>
                                <select name="user_id" id="Karyawan" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <label for="sisa-point">Sisa Poin</label>
                                <input type="text" name="sisa_poin" id="sisa-point" readonly class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Reward</label>
                                <input type="text" name="reward" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Pengurangan Poin</label>
                                <input type="number" name="pengurangan_point" class="form-control" value="0">
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
@endpush

@push('scripts')
    <script>
        $(".table").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [2, 3]
            }]
        });

        $(".add-penukaran-button").on('click', function() {
            $(".add-penukaran-modal").modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.add-penukaran-modal select[name=user_id]').select2({
                // tags: true,
                placeholder: "Karyawan",
                dropdownParent: $('.add-penukaran-modal'),
                ajax: {
                    dataType: "JSON",
                    type: "POST",
                    url: "{{ route('get-list-user') }}",
                    data: function(params) {
                        return {
                            q: params.term, // search term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        }
                    }
                }
            });
            $('.add-penukaran-modal select[name=user_id]').on('change', function() {
                var id = $('.add-penukaran-modal select[name=user_id]').find(":selected").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('point-sales.sisa-poin') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('.add-penukaran-modal input[name=sisa_poin]').val(res.sisa);
                    }
                });
            });

        });

        $('.detail-point-modal .gambar-toggle').on('click', function() {
            $('.detail-point-modal .gambar-point').toggle(300);
        });

        $('.delete-penukaran-button').on('click', function() {
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
                        url: "{{ route('penukaran-point.destroy') }}",
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
