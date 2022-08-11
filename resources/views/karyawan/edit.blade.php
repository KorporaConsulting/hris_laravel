@extends('layouts.app')

@section('content')
<div class="row justify-content-center mb-5">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data {{ $user->name }}</h4>
            </div>
            <form action="{{ route('karyawan.update', $user->id) }}" method="post">
                @csrf
                @method('patch')
                <div class="card-body">
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" name="nip" class="form-control" id="nip" value="{{ $user->nip }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}">
                    </div>
                    {{-- <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div> --}}
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" id="jabatan"
                            value="{{ $user->jabatan }}">
                    </div>
                    <div class="form-group">
                        <label for="mulai_kerja">Mulai Kerja</label>
                        <input type="date" name="mulai_kerja" class="form-control" id="mulai_kerja"
                            value="{{ $user->mulai_kerja }}">
                    </div>
                    <div class="form-group">
                        <label for="tmpt_lahir">Tempat Lahir</label>
                        <input type="text" name="tmpt_lahir" class="form-control" id="tmpt_lahir"
                            value="{{ $user->tmpt_lahir }}">
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir"
                            value="{{ $user->tgl_lahir }}">
                    </div>
                    <div class="form-group">
                        <label for="alamat_ktp">Alamat KTP</label>
                        <textarea name="alamat_ktp" id="alamat_ktp" cols="30" rows="4" class="form-control"
                            style="height: 100px;">{{ $user->alamat_ktp }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="alamat_domisili">Alamat Domisili</label>
                        <textarea name="alamat_domisili" id="alamat_domisili" cols="30" rows="4" class="form-control"
                            style="height: 100px;">{{ $user->alamat_domisili }}</textarea>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="no_hp">Nomor Handphone</label>
                            <input type="number" name="no_hp" class="form-control" id="no_hp"
                                value="{{ $user->no_hp }}">
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="no_hp_darurat">Nomor Handphone Darurat</label>
                            <input type="number" name="no_hp_darurat" class="form-control" id="no_hp_darurat"
                                value="{{ $user->no_hp_darurat }}">
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="gaji">Gaji</label>
                            <input type="text" name="gaji" class="form-control" id="gaji" oninput="currencyInput()"
                                value="{{ number_format($user->gaji, 0, " ,", "." ); }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_pekerja">Status Pekerja</label>
                        <select name="status_pekerja" id="status_user" class="form-control">
                            <option value="pekerja tetap" {{ strtolower($user->status_pekerja) == strtolower('pekerja
                                tetap') ? 'selected' : '' }}>Pekerja Tetap</option>
                            <option value="kontrak" {{ strtolower($user->status_pekerja) == strtolower('kontrak') ?
                                'selected' : '' }}>Kontrak</option>
                            <option value="probation" {{ strtolower($user->status_pekerja) == strtolower('probation') ? 'selected' : '' }}>Probation</option>
                            <option value="freelance" {{ strtolower($user->status_pekerja) == strtolower('freelance') ?
                                'selected' : '' }}>Freelance</option>
                        </select>
                    </div>
                    @if (strtolower($user->status_pekerja) != strtolower('pekerja tetap'))
                    <div class="form-group" id="lama_kontrak_group">
                        <label for="lama_kontrak">Lama Kontrak (Bulan)</label>
                        <input type="number" name="lama_kontrak" class="form-control" id="lama_kontrak"
                            value="{{ $user->lama_kontrak }}">
                    </div>
                    <div class="form-group" id="lama_kontrak_group">
                        <label for="habis_kontrak">Habis Kontrak</label>
                        <input type="date" name="habis_kontrak" class="form-control" id="habis_kontrak"
                            value="{{ $user->habis_kontrak }}" disabled>
                    </div>
                    @endif
                    {{-- <div class="form-group">
                        <label for="divisi">Pilih Divisi</label>
                        <select name="divisi" id="divisi" class="form-control">
                            <option value="" selected>Tidak Masuk divisi Manapun</option>
                            @foreach ($divisions as $division)
                            <option value="{{$division->id}}">{{$division->divisi}}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="form-group" id="level-wrap">
                        <label for="level">Pilih Level</label>
                        <select name="level" id="level" class="form-control">
                            <option value="" selected disabled>Pilih Level</option>
                            <option value="staff" {{ $user->role == 'staff' ? 'selected' : ''}} >Staff</option>
                            <option value="manager" {{ $user->role == 'manager' ? 'selected' : ''}} >Manager</option>
                            <option value="hrd" {{ $user->role == 'hrd' ? 'selected' : ''}} >HRD</option>
                            <option value="direktur" {{ $user->role == 'direktur' ? 'selected' : ''}} >Direktur</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Update</a>
                    </div>
                </div>
        </div>
    </div>
    </form>
</div>
@endsection


@push('scripts')
<script>
    $(function(){
            
            $('#status_user').change(function(){
                if($('#status_user').val() != 'pekerja tetap'){
                    $('#lama_kontrak_group').removeClass('d-none')
                }else{
                    $('#lama_kontrak_group').addClass('d-none')
                    $('#lama_kontrak_group').val('');
                }
            })
        })
</script>
@endpush