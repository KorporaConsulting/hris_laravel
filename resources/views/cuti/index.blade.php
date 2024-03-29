@extends('layouts.app', [
    'page' => 'list cuti ' . auth()->user()->name,
])

@section('head')
@endsection


@section('content')
    <section>

    </section>
    <div class="card">
        <div class="card-header">
            <h4>List Cuti</h4>
        </div>
        <div class="card-body">
            <div class="">
                <table class="table datatable table-striped" id="table-1">
                    <thead>
                        <tr>
                            <th class="text-center">
                                #
                            </th>
                            <th>Nama</th>
                            <th>Jenis Cuti</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cuti as $key => $value)
                            @php
                                $date = date_create($value->created_at);
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->user->name }}</td>
                                <td>{{ $value->jenis_cuti }}</td>
                                <td>{{ date_format($date, 'Y-m-d') }}</td>
                                <td><span
                                        class="text-capitalize badge {{ $value->status == 'waiting' ? 'badge-warning' : ($value->status == 'accept' ? 'badge-success' : 'badge-danger') }}">{{ $value->status }}</span>
                                </td>
                                <td>
                                    {{-- Kalo Udah lewat 1 jam gabisa ubah status accept ke reject maupun sebaliknya --}}
                                    <button class="btn btn-info" data-toggle="modal"
                                        data-target="#infoModal{{ $value->id }}" type="button">Info</button>
                                    @if ($value->status === 'waiting')
                                        <button class="btn btn-primary acc-cuti" data-id="{{ $value->id }}"
                                            data-userid="{{ $value->user->id }}"
                                            data-email="{{ $value->user->email }}">Setujui</button>
                                    @endif
                                </td>
                            </tr>
                            @push('modals')
                                <div class="modal fade" id="infoModal{{ $value->id }}" tabindex="-1"
                                    aria-labelledby="infoModal{{ $value->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="infoModal{{ $value->id }}Label">
                                                    {{ $value->jenis_cuti }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                <div class="form-group">
                                                    <label for="">Nama</label>
                                                    <div>{{ $value->user->name }}</div>
                                                </div>
                                                </p>
                                                <p>
                                                <div class="form-group">
                                                    <label for="">Keterangan</label>
                                                    <div>{{ $value->keterangan_cuti ?? 'Tidak ada keterangan' }}</div>
                                                </div>
                                                </p>
                                                <p>
                                                <div class="form-group">
                                                    <label for="">Mulai Cuti</label>
                                                    <div>{{ date('d F Y', strtotime($value->mulai_tanggal)) }}</div>
                                                </div>
                                                </p>
                                                <p>
                                                <div class="form-group">
                                                    <label for="">Akhir Cuti</label>
                                                    <div>{{ date('d F Y', strtotime($value->sampai_tanggal)) }}</div>
                                                </div>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endpush
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $.ajaxSetup({
            beforeSend: function() {
                $('#preloader').fadeIn();
                $('#ctn-preloader').addClass('no-scroll-y');
            }
        })

        $('.acc-cuti').on('click', function() {
            id = $(this).data('id');
            userid = $(this).data('userid');
            email = $(this).data('email');
            confirmAccept(id, userid, email);
        })

        confirmAccept = function(id, userId, userEmail) {
            let url = '{{ route('cuti.update', ':id') }}'
            Swal.fire({
                title: 'Are you sure?',
                text: "Yakin menyetujui cuti " + "?",
                input: 'textarea',
                inputPlaceholder: 'Keterangan',
                inputAttributes: {
                    required: 'true'
                },
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui!'
            }).then((result) => {
                if (result.isConfirmed) {
                    url = url.replace(':id', id)
                    $.ajax({
                        url,
                        method: 'patch',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: 'accept',
                            keterangan: result.value,
                            userId,
                            userEmail
                        },
                        success: function(res) {

                            location.reload();

                        },
                        error: function(err) {
                            console.log(err)
                            Swal.fire('Error', 'err', 'error');
                        }
                    })
                }
            })
        }

        confirmReject = function(id, name, userId, userEmail) {
            let url = '{{ route('cuti.update', ':id') }}'
            Swal.fire({
                title: 'Are you sure?',
                text: "Yakin menolak cuti " + name + "?",
                input: 'textarea',
                inputPlaceholder: 'Keterangan',
                inputAttributes: {
                    required: 'true'
                },
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tolak!'
            }).then((result) => {
                if (result.isConfirmed) {
                    url = url.replace(':id', id)
                    $.ajax({
                        url,
                        method: 'patch',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: 'reject',
                            keterangan: result.value,
                            userId,
                            userEmail
                        },
                        success: function(res) {
                            if (res.success) {
                                location.reload();
                            }
                        },
                        error: function(err) {
                            console.log(err)
                            Swal.fire('Error', 'err', 'error');
                        }
                    })
                }
            })
        }


        confirmDelete = function(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Yakin ingin menghapus item ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-cuti' + id).submit()
                }
            })
        }
    </script>
@endpush
