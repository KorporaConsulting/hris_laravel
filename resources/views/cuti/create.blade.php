@extends('layouts.app', [
    'page' => 'Ajukan Cuti'
])


@section('content')
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <form action="{{ route('cuti.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="jenis_cuti">Jenis Cuti</label>
                                <input type="text" class="form-control" name="jenis_cuti" id="jenis_cuti" placeholder="Jenis Cuti">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="lama_cuti">Lama Cuti (hari)</label>
                                <input type="number" class="form-control" name="lama_cuti" id="lama_cuti" placeholder="Lama Cuti" min="0">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="jenis_cuti">Mulai Cuti (tanggal</label>
                                <input type="date" class="form-control" name="mulai_tanggal"  value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="cuti_sekarang">Sisa Cuti (Sekarang)</label>
                                <input type="number" class="form-control" name="cuti_sekarang" id="cuti_sekarang" value="{{ auth()->user()->sisa_cuti }}" placeholder="Lama Cuti" min="0" disabled>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="lama_cuti">Keterangan</label>
                                <textarea name="keterangan" class="form-control" id="" cols="30" rows="10" style="height: 150px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button class="btn btn-primary" type="submit">Ajukan</button>
            </div>
            </form> 
        </div>
    </div>
@endsection