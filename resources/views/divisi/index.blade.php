{{-- @extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
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
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>List Divisi</h4>
    </div>
    <div class="card-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Divisi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($divisions as $key => $user)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $user->divisi }}</td>
                    <td>
                        <a href="{{ route('divisi.show', $user->id) }}"
                            class="btn btn-primary">Detail</a>
                        <a href="{{ route('divisi.edit', $user->id) }}"
                            class="btn btn-success">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.btn-delete').click(function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "Data yang sudah di hapus tidak dapat dikembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete'+$(this).data('id')).submit();
                }
            })
        })
</script>
@endpush