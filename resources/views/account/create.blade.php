@extends('layouts.app')

@section('content')
<div class="row justify-content-center mb-5">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Data Karyawan</h4>
            </div>
            <form action="{{ route('account.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" name="nip" class="form-control" id="nip" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" id="jabatan" required>
                    </div>
                    <div class="form-group">
                        <label for="mulai_kerja">Mulai Kerja</label>
                        <input type="date" name="mulai_kerja" class="form-control" id="mulai_kerja" required>
                    </div>
                    <div class="form-group">
                        <label for="tmpt_lahir">Tempat Lahir</label>
                        <input type="text" name="tmpt_lahir" class="form-control" id="tmpt_lahir" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat_ktp">Alamat KTP</label>
                        <textarea name="alamat_ktp" id="alamat_ktp" cols="30" rows="4" class="form-control"
                            style="height: 100px;" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="alamat_domisili">Alamat Domisili</label>
                        <textarea name="alamat_domisili" id="alamat_domisili" cols="30" rows="4" class="form-control"
                            style="height: 100px;" required></textarea>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="no_hp">Nomor Handphone</label>
                            <input type="number" name="no_hp" class="form-control" id="no_hp" required>
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
                            <input type="text" name="gaji" class="form-control" id="gaji" oninput="currencyInput()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_pekerja">Status Pekerja</label>
                        <select name="status_pekerja" id="status_user" class="form-control">
                            <option value="" selected disabled>Status Pekerja</option>
                            <option value="pekerja tetap">Karyawan Tetap</option>
                            <option value="kontrak">Kontrak</option>
                            <option value="probation">Probation</option>
                            <option value="freelance">Freelance</option>
                        </select>
                    </div>
                    <div class="form-group d-none" id="lama_kontrak_group">
                        <label for="lama_kontrak">Lama Kontrak (bulan)</label>
                        <input type="number" name="lama_kontrak" class="form-control" id="lama_kontrak"
                            >
                    </div>
                    <div class="form-group">
                        <label for="divisi">Pilih Divisi</label>
                        <select name="divisi" id="divisi" class="form-control">
                            <option value="" selected>Tidak Masuk divisi Manapun</option>
                            @foreach ($divisions as $division)
                            <option value="{{$division->id}}">{{$division->divisi}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="level-wrap">
                        <label for="level">Pilih Level</label>
                        <select name="level" id="level" class="form-control">
                            <option value="" selected disabled>Pilih Level</option>
                            <option value="staff">Staff</option>
                            <option value="manager">Manager</option>
                            <option value="hrd">HRD</option>
                            <option value="direktur">Direktur</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Tambah</a>
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
            // $('#level-wrap').hide();


            // $('#divisi').change(function(){
            //     if($(this).val()){
            //         $('#level-wrap').show();
            //     }else{
            //         $('#level-wrap').hide();

            //     }
            // })
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