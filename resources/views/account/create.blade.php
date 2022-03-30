@extends('layouts.app')

@section('content')
    <div class="card">
        {{-- <div class="card-header"></div> --}}
        <form action="{{ route('account.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-12 col-lg-8">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" id="jabatan">
                        </div>
                        <div class="form-group">
                            <label for="divisi">Pilih Divisi</label>
                            <select name="divisi" id="divisi" class="form-control" >
                                <option value="" selected disabled>Pilih divisi</option>
                                @foreach ($divisions as $division)
                                    <option value="{{$division->divisi}}">{{$division->divisi}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="level">Pilih Level</label>
                            <select name="level" id="level" class="form-control" >
                                <option value="" selected disabled>Pilih Level</option>
                                @foreach ($levels as $level)
                                    <option value="{{$level->level}}">{{$level->level}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="parent_id">Pilih Penanggung Jawab/Atasan</label>
                            <select name="parent_id" id="parent_id" class="form-control" >
                                <option value="" selected disabled>Pilih Atasan</option>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mulai_kerja">Mulai Kerja</label>
                            <input type="date" name="mulai_kerja" class="form-control" id="mulai_kerja">
                        </div>
                        <div class="form-group">
                            <label for="tmpt_lahir">Tempat Lahir</label>
                            <input type="text" name="tmpt_lahir" class="form-control" id="tmpt_lahir">
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir">
                        </div>
                        <div class="form-group">
                            <label for="alamat_ktp">Alamat KTP</label>
                            <textarea name="alamat_ktp" id="alamat_ktp" cols="30" rows="4" class="form-control" style="height: 100px;"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="alamat_domisili">Alamat Domisili</label>
                            <textarea name="alamat_domisili" id="alamat_domisili" cols="30" rows="4" class="form-control" style="height: 100px;"></textarea>
                        </div>
                        <div>
                            <div class="form-group">
                                <label for="no_hp">Nomor Handphone</label>
                                <input type="number" name="no_hp" class="form-control" id="no_hp">
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label for="no_hp_darurat">Nomor Handphone Darurat</label>
                                <input type="number" name="no_hp_darurat" class="form-control" id="no_hp_darurat">
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label for="gaji">Gaji</label>
                                <input type="number" name="gaji" class="form-control" id="gaji" step="any">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status_user">Status Pekerja</label>
                            <select name="status_user" id="status_user" class="form-control">
                                <option value="pekerja tetap">Pekerja Tetap</option>
                                <option value="kontrak">Kontrak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </form>
    </div>
@endsection