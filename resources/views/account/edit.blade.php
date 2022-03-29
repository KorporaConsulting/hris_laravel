@extends('layouts.app')

@section('head')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>
@endsection

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('account.update') }}" method="post">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Nama</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ auth()->user()->email }}">
                            </div>
                            <div class="form-group">
                                <label for="tmpt_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control" name="tmpt_lahir" id="tmpt_lahir" value="{{ $user->tmpt_lahir }}">
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" value="{{ $user->tgl_lahir }}">
                            </div>
                            <div class="form-group">
                                <label for="alamat_ktp">Alamat KTP</label>
                                <input type="text" class="form-control" name="alamat_ktp" id="alamat_ktp" value="{{ $user->alamat_ktp }}">
                            </div>
                            <div class="form-group">
                                <label for="alamat_domisili">Alamat Domisili</label>
                                <textarea class="form-control" id="alamat_domisili" cols="30" rows="10" name="alamat_domisili" style="height: 100px;">{{ $user->alamat_domisili }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="no_hp">Momor Telepon/HP</label>
                                <input type="number" class="form-control" name="no_hp" id="no_hp" value="{{ $user->no_hp }}">
                            </div>
                            <div class="form-group">
                                <label for="no_hp_darurat">Momor Telepon/HP (Darurat)</label>
                                <input type="number" class="form-control" name="no_hp_darurat" id="no_hp_darurat" value="{{ $user->no_hp_darurat }}">
                            </div>
                            <div class="form-group">
                                <label for="divisi">Divisi</label>
                                <select name="divisi" id="divisi" class="form-control">
                                    @foreach ($divisi as $value)
                                        <option value="{{ $value->divisi }}" {{ $value->divisi == auth()->user()->divisi ? 'selected' : '' }}>{{ $value->divisi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{ $user->jabatan }}">
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection