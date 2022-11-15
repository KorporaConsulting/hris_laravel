@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>List Data Kehadiran</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <form class="form-inline" method="GET" action="{{ route('kehadiran.index') }}">
                        <div class="form-group mb-2">
                            <label for="tgl_awal" class="sr-only">Tanggal Awal</label>
                            <input type="date" class="form-control" name="tgl_awal"
                                value="{{ $_GET['tgl_awal'] ?? date('Y-m-d') }}">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="tgl_akhir" class="sr-only">Tanggal AKhir</label>
                            <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir"
                                value="{{ $_GET['tgl_akhir'] ?? date('Y-m-d') }}">
                        </div>
                        <button type="submit" name="search" value="search" class="btn btn-success mb-2">Search</button>
                        <button type="submit" name="export" value="export"
                            class="btn btn-primary mb-2 mx-sm-3">Report</button>
                    </form>
                </div>
                {{-- <div class="col-lg-6 mt-2">
                <a href="{{ route('kehadiran.report') }}" class="mb-3 btn btn-primary">Report</a>
            </div> --}}
            </div>

            {{-- report kehadiran --}}

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>-</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($presents as $key => $present)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $present->user->name }}</td>
                                        <td>
                                            {{ ucwords($present->user->getRoleNames()[0] ?? '') }}
                                        </td>
                                        <td>{{ $present->created_at->format(' d F Y') }}</td>
                                        <td>{{ $present->created_at->format(' H:i ') }}</td>
                                        <td>{{ $present->type }}</td>
                                        <td>
                                            <button class="btn btn-info btn-edit-kehadiran" id="{{ $present->id }}"
                                                url="{{ route('kehadiran.edit', $present->id) }}">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <div class="modal fade" tabindex="-1" role="dialog" id="edit-kehadiran-modal" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kehadiran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('kehadiran.perbarui') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <select name="type" class="form-control">
                            <option value="alpha">alpha</option>
                            <option value="cuti">cuti</option>
                            <option value="telat">telat</option>
                            <option value="hadir">hadir</option>
                            <option value="sakit">sakit</option>
                            <option value="tidak absen">tidak absen</option>
                            <option value="wfh">wfh</option>
                        </select>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.btn-edit-kehadiran').on('click', function() {
            id = $(this).attr('id');
            url = $(this).attr('url')

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id: id,
                },
                success: function(data) {
                    console.log(data)
                    console.log(data.type)
                    $('#edit-kehadiran-modal').modal('show');
                    $(`#edit-kehadiran-modal select[name=type] option[value=${data.type}]`).attr(
                        'selected', 'selected');
                    $('#edit-kehadiran-modal input[name=id]').val(data.id);

                },
                error: function() {
                    Swal.fire(
                        'Server Error', '', 'error'
                    );
                }
            });
        })
    </script>
@endpush
