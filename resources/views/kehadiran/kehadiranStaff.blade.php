@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presents as $key => $present)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $present->user->name }}</td>
                                <td>
                                    {{ ucwords($present->user->getRoleNames()[0] ?? '') }}
                                </td>
                                <td>{{ $present->created_at->format(' d F Y') }}</td>
                                <td>{{ $present->created_at->format(' H:i ') }}</td>
                                <td>{{ $present->type }}</td>
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