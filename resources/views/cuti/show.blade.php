@extends('layouts.app', [
    'page' => 'list cuti ' . auth()->user()->name
])

@section('content')
<div class="card">
    <div class="card-header">
        <h4>List Cuti</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable table-striped" id="table-1">
               <thead>
                    <tr>
                      <th class="text-center">
                        #
                      </th>
                      <th>Jenis Cuti</th>
                      <th>Tanggal Pengajuan</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cuti as $key => $value)
                        @php
                            $date = date_create($value->created_at);
                        @endphp
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $value->jenis_cuti }}</td>
                            <td>{{  date_format($date, 'Y-m-d') }}</td>
                            <td><span class="text-capitalize badge {{ ($value->status == 'waiting') ? 'badge-warning' : (($value->status == 'accept') ? 'badge-success' :'badge-danger')}}">{{ $value->status }}</span></td>
                                @if ($value->status == 'waiting')
                                <td>
                                    <button class="btn btn-danger" onclick="confirmDelete({{ $value->id }})"><i class="fas fa-trash"></i></button>  
                                </td>
                                <form action="{{ route('cuti.destroy', $value->id) }}" method="post" id="delete-cuti{{ $value->id }}">@csrf @method('delete')</form>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script>
        confirmDelete = function (id){
            Swal.fire({
            title: 'Are you sure?',
            text: "Yakin ingin menghapus item ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
              if (result.isConfirmed) {
                $('#delete-cuti'+id).submit()
              }
          })
        }
    </script>
@endpush