@extends('layouts.app')

@section('content')
    <div class="card">
        {{-- <div class="card-header"></div> --}}
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-12 col-lg-9">
                    <div class="row mb-3">
                        <div class="col-3">Nama</div>
                        <div class="col-9">: {{ auth()->user()->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Email</div>
                        <div class="col-9">: {{ auth()->user()->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Tempat Lahir</div>
                        <div class="col-9">: {{ $user->tmpt_lahir }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Tanggal Lahir</div>
                        <div class="col-9">: {{ $user->tgl_lahir }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Alamat Domisili</div>
                        <div class="col-9">: {{ $user->alamat_domisili }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Alamat KTP</div>
                        <div class="col-9">: {{ $user->alamat_ktp }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Nomor HP</div>
                        <div class="col-9">: {{ $user->no_hp }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Nomor HP Darurat</div>
                        <div class="col-9">: {{ $user->no_hp_darurat }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Jabatan</div>
                        <div class="col-9">: {{ $user->jabatan }}</div>
                    </div>
                </div>
                {{-- {{auth()->user()->img}} --}}
                <div class="col-3">
                    <img src="{{ asset('storage/' . auth()->user()->img )  }}" alt="" class="img-fluid">
                </div>
            </div>
            <div class="text-right">
                <a href="{{ route('account.edit') }}" class="btn btn-success">Edit</a>
            </div>
        </div>
    </div>
@endsection