@extends('layouts.app')


@section('content')
    <div class="card">
        <div class="card-header"><h4>Recycle Karyawan</h4></div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $key => $employee)
                        <tr>
                            <td>{{ $key+1}}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick="revert({{ $employee->id }})">Revert</button>   
                                <form action="{{ route('karyawan.restore', $employee->id) }}" method="post" id="form-{{ $employee->id }}">@csrf @method('patch')</form> 
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
        function revert(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "data yang terhapus akan di kembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Revert it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-'+id).submit();
                }
            })
        }
    </script>
@endpush