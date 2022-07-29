@extends('layouts.app', ['title' => 'Input KPI'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- <div class="d-none d-lg-block col-4">
                Silahkan Isi Form Disamping
            </div> --}}
            <div class="col-12 col-lg-8">
                <form action="{{ route('kpi.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $userId }}">
                    <div class="card">
                        <div class="card-header">
                            <h4>Input KPI</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="proaktif" class="form-label">Proaktif</label>
                                <input type="number" name="proaktif" class="form-control" min="0" step="any" id="proaktif">
                            </div>
                            <div class="form-group">
                                <label for="achivement" class="form-label">Achivement</label>
                                <input type="number" name="achivement" class="form-control" min="0" step="any" id="achivement">
                            </div>
                            <div class="form-group">
                                <label for="service_excellent" class="form-label">Service Excellent</label>
                                <input type="number" name="service_excellent" class="form-control" min="0" step="any" id="service_excellent">
                            </div>
                            <div class="form-group">
                                <label for="spiritual" class="form-label">Spiritual</label>
                                <input type="number" name="spiritual" class="form-control" min="0" step="any" id="spiritual">
                            </div>
                            <div class="form-group">
                                <label for="teamwork" class="form-label">Teamwork</label>
                                <input type="number" name="teamwork" class="form-control" min="0" step="any" id="teamwork">
                            </div>
                            <div class="form-group">
                                <label for="inovatif" class="form-label">Inovatif</label>
                                <input type="number" name="inovatif" class="form-control" min="0" step="any" id="inovatif">
                            </div>
                            <div class="form-group">
                                <label for="bulan">Bulan Ke</label>
                                <input type="month" class="form-control" name="bulan" id="bulan" value="{{ date('Y-m') }}">
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" id="" cols="30" rows="10" class="form-control" style="height: 100px;"></textarea>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection