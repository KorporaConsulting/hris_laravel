@extends('layouts.app')

@section('content')
<div class="row justify-content-center mb-5">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Divisi</h4>
            </div>
            <form action="{{ route('divisi.index') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nip">Nama Divisi</label>
                        <input type="text" name="divisi" class="form-control" id="divisi" value="{{ old('divisi') ?? '' }}" value="{{ old('nip') ?? '' }}" required>
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