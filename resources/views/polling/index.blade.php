@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>List Polling</h4>
    </div>
    <div class="card-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Polling</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pollings as $key => $polling)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $polling->judul }}</td>
                    <td>{{ $polling->created_by->name }}</td>
                    <td>
                        <a href="{{ route('pengumuman.show', $polling->id) }}" class="btn btn-primary">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection