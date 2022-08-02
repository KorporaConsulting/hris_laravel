@extends('layouts.app')


@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Pengumuman</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="judul" class="form-label">Judul</label>
                    <div>
                        {{ $pengumuman->judul }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="judul" class="form-label">Deskripsi/Detail</label>
                    <div>
                        {!! $pengumuman->deskripsi !!}
                    </div>
                </div>
                <div class="form-group mb-5">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="judul" class="form-label">Tanggal Mulai</label>
                            <div>
                                {!! $pengumuman->date_start !!}
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label for="judul" class="form-label">Tanggal Berakhir</label>
                            <div>
                                {!! $pengumuman->date_end !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    <label for="judul" class="form-label">Dibuat Oleh</label>
                    <div>
                        {!! $pengumuman->created_by->name !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection