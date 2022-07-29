@extends('layouts.app', [
'page' => 'Data Kpi'
])



@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div><h4>List KPI {{ $user->name }}</h4></div>
        <div class=>
            <a href="{{ route('karyawan.kpi.create', $user->id) }}" class="btn btn-primary">Input KPI</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    
                    <table class="table datatable">
                        <thead>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Total Point</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($user->kpi as $key => $kpi)
                                @php
                                    $totalPoint = $kpi->proaktif+$kpi->achivement+$kpi->service_excellent+$kpi->spiritual+$kpi->teamwork+$kpi->inovatif;
                                @endphp
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ date("d F, Y", strtotime($kpi->created_at)) }}</td>
                                    <td>{{ $totalPoint }}</td>
                                    <td><a href="{{ route('karyawan.kpi.show', [$user->id, $kpi->id]) }}" class="btn btn-success">Detail</a></td>
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