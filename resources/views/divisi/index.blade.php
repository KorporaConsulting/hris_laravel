@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Divisi</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($divisions as $key => $divisi)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $divisi->divisi }}</td>
                                <td><a href="{{ route('divisi.show', $divisi->id) }}" class="btn btn-primary">Lihat Anggota</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection