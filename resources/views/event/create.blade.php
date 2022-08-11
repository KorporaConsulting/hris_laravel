@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Buat Event Calender</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('event.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="date_start" id="date_start">
                        <input type="hidden" name="date_end" id="date_end">
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" name="title" id="title" placeholder="Judul" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" style="height: 100px;" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Range Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control daterange-cus" id="range-date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="days">Day Reminder</label>
                            <select name="days[]" class="form-control select2" id="days" multiple>
                                <option value="monday">Senin</option>
                                <option value="tuesday">Selasa</option>
                                <option value="wednesday">Rabu</option>
                                <option value="thursday">Kamis</option>
                                <option value="friday">jumat</option>
                                <option value="saturday">saturday</option>
                                <option value="sunday">sunday</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
         $('#range-date').change(function(){
            console.log($(this).val());
            const split = $(this).val().split(' - ');
            $('#date_start').val(split[0]);
            $('#date_end').val(split[1]);
        })

        $('.daterange-cus').daterangepicker({
            locale: {format: 'YYYY-MM-DD'},
            drops: 'down',
            opens: 'right'
        });
    </script>
@endpush