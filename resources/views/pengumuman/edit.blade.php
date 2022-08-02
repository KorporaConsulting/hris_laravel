@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="post">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="date_start" id="date_start">
                        <input type="hidden" name="date_end" id="date_end">
                        <div class="form-group">
                            <label for="judul" class="">Judul</label>
                            <input type="text" name="judul" id="judul" placeholder="Judul Pengumuman"
                                class="form-control" value="{{ $pengumuman->judul }}">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi" class="">Keterangan Detail</label>
                            <textarea class="" name="deskripsi" id="deskripsi" cols="30" rows="10"
                                style="height: 100px;">{!! $pengumuman->deskripsi !!}</textarea>
                        </div>

                        <div class="form-group">
                            <div class="control-label">Penerima Pengumuman</div>
                            <select multiple name="to[]" id="to" class="form-control select2">
                                {{-- <option value="all" selected id="">Semua</option> --}}
                                @foreach ($users as $user)
                                    <option 
                                        value="{{ $user->id }}" 
                                        {{ in_array($user->id, $pengumuman->users->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-check my-1">
                                <input class="form-check-input" type="checkbox" id="select-all">
                                <label class="form-check-label" for="defaultCheck1">
                                    Select All
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Range Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control daterange-cus" id="range-date" 
                                    value="{{ $pengumuman->date_start . ' - ' . $pengumuman->date_end }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    $(document).ready(function() {
            if(jQuery().summernote) {
                $("#deskripsi").summernote({
                    dialogsInBody: true,
                    minHeight: 250,
                });
            }
        });
        $("#select-all").click(function(){
            console.log($("#select-all").is(':checked'))
            if($("#select-all").is(':checked')){
                $(".select2 > option").prop("selected", true);
                $(".select2").trigger("change");
            }else{
                $(".select2 > option").prop("selected", false);
                $(".select2").trigger("change");
            }
        });

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