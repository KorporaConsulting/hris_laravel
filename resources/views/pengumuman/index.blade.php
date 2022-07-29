@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>List Pengumuman</h4>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengumuman</th>
                        <th>Created By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($announcements as $key => $announcement)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $announcement->judul }}</td>
                            <td>{{ $announcement->created_by->name }}</td>
                            <td>
                                <a href="{{ route('pengumuman.show', $announcement->id) }}" class="btn btn-primary">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection