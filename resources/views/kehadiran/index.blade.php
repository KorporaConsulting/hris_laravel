@extends('layouts.app')


@section('content')
<div class="card">
    <div class="card-header">
        <h4>List Data Kehadiran</h4>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-lg-12">
                <form class="form-inline" method="GET" action="{{ route('kehadiran.index') }}">
                    @csrf
                    <div class="form-group mb-2">
                      <label for="tgl_awal" class="sr-only">Tanggal Awal</label>
                      <input type="date" class="form-control" name="tgl_awal">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                      <label for="tgl_akhir" class="sr-only">Tanggal AKhir</label>
                      <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir">
                    </div>
                    <button type="submit" name="search" value="search" class="btn btn-success mb-2">Search</button>
                    <button type="submit" name="export" value="export" class="btn btn-primary mb-2 mx-sm-3">Report</button>
                  </form>
            </div>
            {{-- <div class="col-lg-6 mt-2">
                <a href="{{ route('kehadiran.report') }}" class="mb-3 btn btn-primary">Report</a>
            </div> --}}
        </div>
        
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