@extends('layouts.app', [
    'page' => 'Data Kpi'
])



@section('content')
<div class="card">
    <div class="card-header">
        <h4>List Karyawan</h4>
    </div>
    <div class="card-body">
        <div class="">
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
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $user->name}}</td>
                            <td>{{ $user->email}}</td>
                            <td>
                                <a href="{{ route('kpi.show', $user->id) }}" class="btn btn-primary">Lihat KPI</a>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addkpi{{$key}}">
                                    Beri KPI
                                </button>
                                @push('modals')
                                    @component('components.modal_form',[
                                        'name' => 'addkpi'.$key,
                                        'title' => 'Tambah KPI',
                                        'url' => route('kpi.index')
                                    ])
                                        @slot('content')
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <div class="form-group">
                                                <label for="karyawan{{$key}}">Nama Karyawan</label>
                                                <input type="text" class="form-control" id="karyawan{{$key}}" value="{{$user->name}}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="point{{$key}}">Point</label>
                                                <input type="number" class="form-control" name="point" id="point{{$key}}" min="0">
                                            </div>
                                            <div class="form-group">
                                                <label for="month{{$key}}">Bulan Ke</label>
                                                <input type="month" class="form-control" name="month" id="month{{$key}}" value="{{ date('Y-m') }}">
                                            </div>
                                        @endslot
                                    @endcomponent
                                @endpush
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
        $('form').submit(function(e){
            event.preventDefault();
            $.ajax({
                url:$(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(res){
                    if(res.success){
                        location.reload();
                    }
                },
                error: function(err){
                    Swal.fire('Error', 'Server Error', 'error');
                }
            })
        })
    </script>
@endpush

