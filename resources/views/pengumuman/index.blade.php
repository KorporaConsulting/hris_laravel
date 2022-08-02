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
                        <a href="{{ route('pengumuman.show', $announcement->id) }}"
                            class="btn btn-primary">Detail</a>
                        <a href="{{ route('pengumuman.edit', $announcement->id) }}"
                            class="btn btn-success">Edit</a>
                        <button class="btn btn-danger btn-delete" type="button"
                            data-id="{{$key}}">Delete</button>
                        <form action="{{ route('pengumuman.destroy', $announcement->id) }}" method="POST" id="delete{{$key}}">
                            @csrf
                            @method('delete')
                        </form>
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