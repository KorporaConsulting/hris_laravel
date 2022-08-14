@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
    integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
    crossorigin="" />
<style>
    #map {
        height: 180px;
    }
</style>
@endsection


@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Absen</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-3">
                    <div id="demo"></div>
                    <div id="map"></div>
                </div>
                <div class="col-12">
                    @if ($absen)
                    <div><a href="{{ route('kehadiran.present') }}" class="btn btn-primary" id="absen">Absen</a></div>
                    @else
                    <div>{{ $message }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
    integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
    crossorigin=""></script>

<script>
    var x = document.getElementById("demo");



        // async function getLocation (){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
            }
        // }

        function showPosition(position){
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            var map = L.map('map', {
            'center': [0, 0],
            'zoom': 0,
            'layers': [
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            'attribution': 'Map data &copy; OpenStreetMap contributors'
            })
            ]
            });
            
            L.Circle.include({
            contains: function (latLng) {
            return this.getLatLng().distanceTo(latLng) < this.getRadius(); } }); 
            var circle=L.circle([-6.315699800864124, 106.79691298625411],
                100).addTo(map); 
                map.fitBounds(circle.getBounds()); 
                // map.on('click', function (e) {
                    // console.log
                    var marker = L.marker({lat: latitude, lng: longitude}).addTo(map); 
                    var result=(circle.contains(marker.getLatLng())) ? 'didalam' : 'diluar' ;
                    marker.bindPopup('Lokasi anda  ' + result + ' jangkauan'); marker.openPopup(); 

                    if(circle.contains(marker.getLatLng())){
                        
                    }else{
                        Swal.fire('Pemberitahuan', 'Anda berada diluar jangkauan', 'warning');
                        $('#absen').addClass('disabled');
                    }
                // }); 
              
        }

</script>
@endpush