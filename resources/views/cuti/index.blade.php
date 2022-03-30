@extends('layouts.app', [
    'page' => 'list cuti ' . auth()->user()->name
])

@section('content')
<div class="card">
    <div class="card-header">
        <h4>List Cuti</h4>
    </div>
    <div class="card-body">
        <div class="">
            <table class="table datatable table-striped" id="table-1">
               <thead>
                    <tr>
                      <th class="text-center">
                        #
                      </th>
                      <th>Nama</th>
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
                            <td>{{ $value->user->name }}</td>
                            <td>{{ $value->jenis_cuti }}</td>
                            <td>{{  date_format($date, 'Y-m-d') }}</td>
                            <td class="badge {{ $value->status == 'waiting' ? 'badge-warning' : $value->status == 'accept' ? 'badge-success' : 'badge-danger'}}">{{ $value->status }}</td>
                            <td>
                                <button class="btn btn-primary" onclick="confirmAccept({{ $value->id }}, '{{ $value->user->name }}', '{{ $value->user->id }}')">Setujui</button>  
                                <button class="btn btn-danger" onclick="confirmReject({{ $value->id }}, '{{ $value->user->name }}')">Tolak</button>  
                            </td>
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
        confirmAccept = function (id, name, userId){
            let url = '{{ route("cuti.update", ":id") }}'
            Swal.fire({
            title: 'Are you sure?',
            text: "Yakin menyetujui cuti "+name+"?",
            input: 'textarea',
            inputPlaceholder: 'Keterangan',
            inputAttributes: {
                required: 'true'
            },
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setujui!'
        }).then((result) => {
            url = url.replace(':id', id)
            $.ajax({
                url,
                method: 'patch',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: 'accept',
                    keterangan: result.value,
                    userId
                },
                success: function (res){
                    if(res.success){
                        location.reload();
                    }
                },
                error: function (err){
                    Swal.fire('Error', 'err', 'error');
                }
            })
          })
        }

        confirmReject = function (id, name, userId){
            let url = '{{ route("cuti.update", ":id") }}'
            Swal.fire({
            title: 'Are you sure?',
            text: "Yakin menolak cuti "+name+"?",
            input: 'textarea',
            inputPlaceholder: 'Keterangan',
            inputAttributes: {
                required: 'true'
            },
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setujui!'
        }).then((result) => {
            url = url.replace(':id', id)
            $.ajax({
                url,
                method: 'patch',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: 'reject',
                    keterangan: result.value,
                    userId
                },
                success: function (res){
                    if(res.success){
                        location.reload();
                    }
                },
                error: function (err){
                    Swal.fire('Error', 'err', 'error');
                }
            })
          })
        }


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