@extends('layouts.app', [
    'page' => 'Data Kpi'
])



@section('content')
<div class="card">
    <div class="card-header">
        <h4>List Karyawan</h4>
    </div>
    <div class="card-body">
        <div>
            <canvas id="myChart"></canvas>
        </div>        
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = {!! json_encode($kpi->pluck("bulan")) !!}
        console.log(labels);
        const data = {
          labels: labels,
          datasets: [{
            label: 'Point KPI Tahun ini',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: {!! json_encode($kpi->pluck("point")) !!},
          }]
        };

        const config = {
          type: 'line',
          data: data,
          options: {}
        };



      </script>
      <script>
        const myChart = new Chart(
          document.getElementById('myChart'),
          config
        );
      </script>      
@endpush

