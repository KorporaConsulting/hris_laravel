@extends('layouts.app')


@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>Polling Chart</h4>
            </div>
            <div class="card-body">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Polling</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">{{ $polling->judul }}</label>
                </div>
                <div class="form-group">
                    <label for="judul" class="form-label">Opsi</label></>
                    <ul>
                        @foreach ($polling->options as $option)
                            <li>{{ $option->opsi }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="form-group">
                    Created By : {{ $polling->created_by->name }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script>
        let data = {!! $polling->options !!};

        data = data.map((value, key) => {
            return value.answers.length
        })
        const ctx = document.getElementById('myChart');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! $polling->options->pluck("opsi") !!},
                datasets: [{
                    label: '# of Votes',
                    data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush