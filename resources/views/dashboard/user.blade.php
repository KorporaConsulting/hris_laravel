@extends('layouts.app')



@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h3 class="mb-3">Selamat Datang {{ auth()->user()->name }} ({{ auth()->user()->getRoleNames()[0] }})</h3>
                        
                        <ul>
                            <li><a href="#pengumuman">Pengumuman</a></li>
                            <li><a href="#polling">Polling</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>Absensi</h4>
            </div>
            <div class="card-body">
            <canvas id="absensiChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-8"></div>
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 id="pengumuman">Pengumuman</h4>
            </div>
        </div>
        @forelse ($announcements as $announcement)
            <div class="card">
                <div class="card-body">
                    <h4>{{ $announcement->created_by->name }}</h4>
                    <p>
                        {!! $announcement->deskripsi !!}
                    </p>
                </div>
            </div>
        @empty
            
        @endforelse
        
    </div>
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 id="polling">Polling</h4>
            </div>
        </div>
        @forelse ($pollings as $polling)
            <div class="card">
                <div class="card-body">
                    <h4>{{ $polling->created_by->name }}</h4>
                    <p>
                        {{ $polling->judul }}
                    </p>
                    <div class="options">
                        @foreach ($polling->options as $key => $option)
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username"
                                    aria-describedby="button-addon2" value="{{ $option->opsi }}" disabled>
                                <div class="input-group-append">
                                    @if (!empty($polling->answer))
                                        @if ($polling->answer->opsi_id === $option->id)
                                            <button class="btn btn-success opsi-polling opsi-polling{{$polling->id}}" type="button" data-polling="{{$polling->id}}" data-opsi="{{ $option->id }}">Selected</button>
                                        @else
                                            <button class="btn btn-secondary opsi-polling opsi-polling{{$polling->id}}" type="button" data-polling="{{ $polling->id }}" data-opsi="{{ $option->id }}">Vote</button>
                                        @endif    
                                    @else
                                    <button class="btn btn-secondary opsi-polling opsi-polling{{$polling->id}}" type="button" data-polling="{{$polling->id}}" data-opsi="{{ $option->id }}">Vote</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    <div class="text-right"><small>{{ $polling->answers_count }} Orang Telah Vote</small></div>
                    </div>
                </div>
            </div>
        @empty
            
        @endforelse
        
    </div>
</div>

</div>
@endsection


@push('scripts')
    <script>
        
        $('.opsi-polling').click(function(e){
            $('.opsi-polling'+$(this).data('polling')).html('Vote');
            $('.opsi-polling'+$(this).data('polling')).removeClass('btn-success');
            $('.opsi-polling'+$(this).data('polling')).addClass('btn-secondary');

            $(this).removeClass('btn-secondary')
            $(this).addClass('btn-success')
            $(this).html('Selected')

            $.ajax({
                url: '{{ route("polling.vote") }}',
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    polling_id: $(this).data('polling'),
                    opsi_id: $(this).data('opsi')
                },
                success: function(res){
                    if(res.success){
                        console.log('success');
                        iziToast.success({
                            title: 'success',
                            message: res.message,
                            position: 'topRight'
                        });
                    }
                },
                error: function(err){
                    console.log(err);
                }
            })
        })

        // let obj = new Obj({!! $presents !!});

        let absensiData = {!! $presents !!};

        const labels = ['hadir', 'cuti', 'alpha', 'telat'];

        const data = [];

        labels.forEach(e => {
            data.push(absensiData[e]?.length ?? 0);
        })

        const ctx = document.getElementById('absensiChart');
        const absensiChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels,
                datasets: [{
                    label: 'My First Dataset',
                    data,
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(85, 239, 196)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            }
        });
    </script>
@endpush

{{-- @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
    integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async>
</script>
<script>
    $.ajax({
            url: 'https://api.unsplash.com/search/photos?page=1&query=office&client_id=dkp_kqRcMn1kkA8FyZjFxpgq3IVngB8GcGBFWjM2DSY',
            // headers: {
            //     Authorization: 'Bearer dkp_kqRcMn1kkA8FyZjFxpgq3IVngB8GcGBFWjM2DSY'
            // },
            method: 'GET',
            success: function(res){ 
                console.log(res);
                let html = '';
                res.results.forEach(e => {
                    html+= `<div class="col-lg-4">
                                <img src="${e.urls.raw}" class="img-fluid" alt="">
                            </div>`
                })
                $('#wrap-images').html(html);
            }
        })
</script>
@endpush --}}