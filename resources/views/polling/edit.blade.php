@extends('layouts.app')


@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Buat Polling</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('polling.update', $polling->id) }}" method="post">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="date_start" id="date_start">
                    <input type="hidden" name="date_end" id="date_end">
                    <div class="form-group">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" name="judul" id="judul" placeholder="Judul" class="form-control" value="{{ $polling->judul }}">
                    </div>
                    <div class="form-group">
                        <label>Range Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control daterange-cus" id="range-date" value="{{ $polling->date_start . ' - ' . $polling->date_end }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-1"><label for="judul" class="form-label">Opsi</label></div>
                        <button id="tambah-opsi" type="button" class="btn btn-success mb-3">Tambah Opsi</button>
                        <div id="opsi-wrap">
                            @foreach ($polling->options as $option)
                                <div class="input-group opsi mb-3">
                                    <input type="text" name="opsi[]" class="form-control" placeholder="Opsi Polling" aria-label="Recipient's username"
                                        aria-describedby="button-addon2" value="{{ $option->opsi }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-danger opsi-button" type="button"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="form-group text-right mt-5">
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let opsi = 0;

    $('#tambah-opsi').click(function(e){
        $('#opsi-wrap').append(`<div class="input-group opsi mb-3">
            <input type="text" name="opsi[]" class="form-control" placeholder="Opsi Polling" aria-label="Recipient's username"
                aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-danger opsi-button" type="button"><i class="fas fa-trash"></i></button>
            </div>
        </div>`);
        
    })

    $('#opsi-wrap').on('click', '.opsi-button', function(e){
        console.log($(this).closest('.opsi').remove());
    })

    $('#range-date').change(function(){
        console.log($(this).val());
        const split = $(this).val().split(' - ');
        $('#date_start').val(split[0]);
        $('#date_end').val(split[1]);
        // const date_start = moment(split[0]);
        // const date_end = moment(split[1]);
    })
    
    $('.daterange-cus').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        drops: 'down',
        opens: 'right'
    });
</script>
@endpush