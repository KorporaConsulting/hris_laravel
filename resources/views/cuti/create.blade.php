@extends('layouts.app', [
'page' => 'Ajukan Cuti'
])


@section('content')
<div class="card">
    <div class="card-header">
        <h4>Pengajuan Cuti</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('cuti.store') }}" method="post">
            @csrf
            @if ($user->sisa_cuti > 0)
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="jenis_cuti">Jenis Cuti</label>
                                    <select name="jenis_cuti" id="jenis_cuti" class="form-control">
                                        <option selected disabled>Pilh Jenis Cuti</option>
                                        <option value="Cuti Sakit">Cuti Sakit</option>
                                        <option value="Cuti Tahunan">Cuti Tahunan</option>
                                        <option value="Cuti Menikah">Cuti Menikah</option>
                                        <option value="Cuti Haid">Cuti Haid</option>
                                        <option value="Cuti Bersalin">Cuti Bersalin</option>
                                        <option value="Cuti Besar">Cuti Besar</option>
                                        <option value="Cuti Bersama">Cuti Bersama</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="lama_cuti">Lama Cuti (hari)</label>
                                    <input type="number" class="form-control disable" name="lama_cuti" id="lama_cuti"
                                        placeholder="Lama Cuti"  min="0" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tanggal Cuti</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control daterange-cus" name="tanggal_cuti" id="tanggal_cuti">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cuti_sekarang">Sisa Cuti (Sekarang)</label>
                                    <input type="number" class="form-control" name="sisa_cuti" id="sisa_cuti"
                                        value="{{ $user->sisa_cuti }}" placeholder="Lama Cuti" min="0" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="lama_cuti">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" id="" cols="30" rows="10"
                                        style="height: 150px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-primary" type="submit">Ajukan</button>
                </div>
            @else
                <div class="alert alert-success">Jatah Cuti Habis</div>
            @endif

        </form>
    </div>
</div>
@endsection


@push('scripts')
<script>

    function checkedRangeDate(data, separator){
        const split = data.split(separator);
        const date_start = moment(split[0]);
        const date_end = moment(split[1]);

        return [
            date_start, date_end
        ];
    }


    let prevLamaCuti = $('#lama_cuti').val();
    let prevTanggalCuti = $('#tanggal_cuti').val()

    $('#tanggal_cuti').change(function(){
        const split = $(this).val().split(' - ');
        const date_start = moment(split[0]);
        const date_end = moment(split[1]);
        const lama_cuti = date_end.diff(date_start, 'days') + 1;

        if(lama_cuti > $('#sisa_cuti').val()){
            Swal.fire('Pemberitahuan', 'Lama cuti melewati sisa cuti', 'warning');
            $('#lama_cuti').val(prevLamaCuti)
            const getPrevTanggalCuti = checkedRangeDate(prevTanggalCuti, ' - ');
            $('#tanggal_cuti').daterangepicker({locale: {format: 'YYYY-MM-DD'}, startDate: getPrevTanggalCuti[0], endDate: getPrevTanggalCuti[1] });
        }else{
            $('#lama_cuti').val(lama_cuti)
        }

        prevLamaCuti = $('#lama_cuti').val();

        prevTanggalCuti = $('#tanggal_cuti').val()

    })

    $('.daterange-cus').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        drops: 'down',
        opens: 'right'
    });



</script>
@endpush
