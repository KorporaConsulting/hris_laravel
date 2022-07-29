@extends('layouts.app', [
'page' => 'Data Kpi'
])



@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail KPI {{ $kpi->name }}</h4>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="row mb-3">
                        <div class="col-6 col-lg-4">Proaktif</div>
                        <div class="col-6 col-lg-8">: {{ $kpi->proaktif }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 col-lg-4">Achivement</div>
                        <div class="col-6 col-lg-8">: {{ $kpi->achivement }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 col-lg-4">Service Excellent</div>
                        <div class="col-6 col-lg-8">: {{ $kpi->service_excellent }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 col-lg-4">Spiritual</div>
                        <div class="col-6 col-lg-8">: {{ $kpi->spiritual }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 col-lg-4">Teamwork</div>
                        <div class="col-6 col-lg-8">: {{ $kpi->teamwork }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 col-lg-4">Inovatif</div>
                        <div class="col-6 col-lg-8">: {{ $kpi->inovatif }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 col-lg-4"><span class="h6 font-weight-bold">Total Point</span></div>
                        <div class="col-6 col-lg-8">: <span class="h6 font-weight-bold">{{ $kpi->proaktif+$kpi->achivement+$kpi->service_excellent+$kpi->spiritual+$kpi->teamwork+$kpi->inovatif }}</span></div>
                    </div>
                </div>
                <div class="col-12">
                    <textarea class="form-control" style="height: 100px" disabled>{{$kpi->keterangan}}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection