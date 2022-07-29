@extends('layouts.app')



@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Status Pekerja</th>
                            <th>Jabatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                @if ($user->karyawan->is_active > 0)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>{{ $user->karyawan->jabatan}}</td>
                            <td>
                                <a href="{{ route('karyawan.edit', $user->id) }}" class="btn btn-success">Edit</a>
                                <a href="{{ route('karyawan.kpi.index', $user->id) }}" class="btn btn-primary">Lihat KPI</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


