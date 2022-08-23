@extends('layouts.app')


@section('content')
<div class="card">
    <div class="card-header">
        <h4>List Data Kehadiran</h4>
    </div>
    <div class="card-body">
        <a href="{{ route('kehadiran.report') }}" class="mb-3 btn btn-primary">Report</a>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Waktu Absen</th>
                                <th>level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presents as $key => $present)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $present->user->name }}</td>
                                <td>{{ $present->created_at }}</td>
                                <td>
                                    {{ ucwords($present->user->getRoleNames()[0]) ?? '' }}
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