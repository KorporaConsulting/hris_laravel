<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $title ?? 'Korpora - HRIS' }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css')}}" integrity="" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css') }}">
    
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="../node_modules/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="../node_modules/weathericons/css/weather-icons.min.css">
    <link rel="stylesheet" href="../node_modules/weathericons/css/weather-icons-wind.min.css">
    <link rel="stylesheet" href="../node_modules/summernote/dist/summernote-bs4.css"> --}}

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css"
        integrity="sha512-gp+RQIipEa1X7Sq1vYXnuOW96C4704yI1n0YB9T/KqdvqaEgL6nAuTSrKufUX3VBONq/TPuKiXGLVgBKicZ0KA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"
        integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* #preloader{
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: black;
            width: 100%;
            height: 100%;
            z-index: 99999;
        }

        html{
            scroll-behavior: smooth;
        }

        #custom-target {
            position: relative;
            width: 600px;
            height: 300px;
            border-style: solid;
        }
        
        .position-absolute {
            position: absolute;
        } */

        .no-scroll-y {
        overflow-y: hidden;
        }
        
        /* Preloader */
        .ctn-preloader {
        align-items: center;
        cursor: none;
        display: flex;
        height: 100%;
        justify-content: center;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        z-index: 900;
        }
        
        .ctn-preloader .animation-preloader {
        position: absolute;
        z-index: 100;
        }
        
        /* Spinner cargando */
        .ctn-preloader .animation-preloader .spinner {
        animation: spinner 1s infinite linear;
        border-radius: 50%;
        border: 3px solid rgba(0, 0, 0, 0.2);
        border-top-color: #000000; /* No se identa por orden alfabetico para que no lo sobre-escriba */
        height: 9em;
        margin: 0 auto 3.5em auto;
        width: 9em;
        }
        
        /* Texto cargando */
        .ctn-preloader .animation-preloader .txt-loading {
        font: bold 5em 'Montserrat', sans-serif;
        text-align: center;
        user-select: none;
        }
        
        .ctn-preloader .animation-preloader .txt-loading .letters-loading:before {
        animation: letters-loading 4s infinite;
        color: #000000;
        content: attr(data-text-preloader);
        left: 0;
        opacity: 0;
        position: absolute;
        top: 0;
        transform: rotateY(-90deg);
        }
        
        .ctn-preloader .animation-preloader .txt-loading .letters-loading {
        color: rgba(0, 0, 0, 0.2);
        position: relative;
        }
        
        .ctn-preloader .animation-preloader .txt-loading .letters-loading:nth-child(2):before {
        animation-delay: 0.2s;
        }
        
        .ctn-preloader .animation-preloader .txt-loading .letters-loading:nth-child(3):before {
        animation-delay: 0.4s;
        }
        
        .ctn-preloader .animation-preloader .txt-loading .letters-loading:nth-child(4):before {
        animation-delay: 0.6s;
        }
        
        .ctn-preloader .animation-preloader .txt-loading .letters-loading:nth-child(5):before {
        animation-delay: 0.8s;
        }
        
        .ctn-preloader .animation-preloader .txt-loading .letters-loading:nth-child(6):before {
        animation-delay: 1s;
        }
        
        .ctn-preloader .animation-preloader .txt-loading .letters-loading:nth-child(7):before {
        animation-delay: 1.2s;
        }
        
        .ctn-preloader .loader-section {
        background-color: #ffffff;
        height: 100%;
        position: fixed;
        top: 0;
        width: calc(50% + 1px);
        }
        
        .ctn-preloader .loader-section.section-left {
        left: 0;
        }
        
        .ctn-preloader .loader-section.section-right {
        right: 0;
        }
        
        /* Efecto de fade en la animación de cargando */
        .loaded .animation-preloader {
        opacity: 0;
        transition: 0.3s ease-out;
        }
        
        /* Efecto de cortina */
        .loaded .loader-section.section-left {
        transform: translateX(-101%);
        transition: 0.7s 0.3s all cubic-bezier(0.1, 0.1, 0.1, 1.000);
        }
        
        .loaded .loader-section.section-right {
        transform: translateX(101%);
        transition: 0.7s 0.3s all cubic-bezier(0.1, 0.1, 0.1, 1.000);
        }
        
        /* Animación del preloader */
        @keyframes spinner {
        to {
        transform: rotateZ(360deg);
        }
        }
        
        /* Animación de las letras cargando del preloader */
        @keyframes letters-loading {
        0%,
        75%,
        100% {
        opacity: 0;
        transform: rotateY(-90deg);
        }
        
        25%,
        50% {
        opacity: 1;
        transform: rotateY(0deg);
        }
        }
        
        /* Tamaño de portatil hacia atras (portatil, tablet, celular) */
        @media screen and (max-width: 767px) {
        /* Preloader */
        /* Spinner cargando */
        .ctn-preloader .animation-preloader .spinner {
        height: 8em;
        width: 8em;
        }
        
        /* Texto cargando */
        .ctn-preloader .animation-preloader .txt-loading {
        font: bold 3.5em 'Montserrat', sans-serif;
        }
        }
        
        @media screen and (max-width: 500px) {
        /* Prelaoder */
        /* Spinner cargando */
        .ctn-preloader .animation-preloader .spinner {
        height: 7em;
        width: 7em;
        }
        
        /* Texto cargando */
        .ctn-preloader .animation-preloader .txt-loading {
        font: bold 2em 'Montserrat', sans-serif;
        }
        }

    </style>
    @yield('head')
</head>

<body class="no-scroll-y">
    <div id="preloader">
        <div id="ctn-preloader" class="ctn-preloader">
            <div class="animation-preloader">
                <div class="spinner"></div>
                <div class="txt-loading">
                    <span data-text-preloader="L" class="letters-loading">
                        L
                    </span>
    
                    <span data-text-preloader="O" class="letters-loading">
                        O
                    </span>
    
                    <span data-text-preloader="A" class="letters-loading">
                        A
                    </span>
    
                    <span data-text-preloader="D" class="letters-loading">
                        D
                    </span>
    
                    <span data-text-preloader="I" class="letters-loading">
                        I
                    </span>
    
                    <span data-text-preloader="N" class="letters-loading">
                        N
                    </span>
    
                    <span data-text-preloader="G" class="letters-loading">
                        G
                    </span>
                </div>
            </div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
    </div>
    <div id="swal-toast"></div>
    @stack('modals')
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
                @include('partials.nav')
            <div class="main-sidebar">
                @include('partials.sidebar')
            </div>

        <!-- Main Content -->
            <div class="main-content pageKanban">
                    <section class="section">
                        {{-- <div class="section-header">
                            <h1>{{ $page ?? config('app.name') }}</h1>
                        </div> --}}
                        <div class="section-body">
                            {{-- <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                    <i class="far fa-user"></i>
                                    </div>
                                    <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Admin</h4>
                                    </div>
                                    <div class="card-body">
                                        10
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-danger">
                                    <i class="far fa-newspaper"></i>
                                    </div>
                                    <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>News</h4>
                                    </div>
                                    <div class="card-body">
                                        42
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-warning">
                                    <i class="far fa-file"></i>
                                    </div>
                                    <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Reports</h4>
                                    </div>
                                    <div class="card-body">
                                        1,201
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-success">
                                    <i class="fas fa-circle"></i>
                                    </div>
                                    <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Online Users</h4>
                                    </div>
                                    <div class="card-body">
                                        47
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div> --}}
                            @yield('content')
                        </div>
                    </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; {{ date('Y') }} Korpora Consulting</a>
                </div>
                <div class="footer-right">
                    2.3.0
                </div>
            </footer>
        </div>
    </div>
    <form action="{{ route('logout') }}" method="post" id="form-logout">@csrf</form>
    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/1.0.3/numeral.min.js"
        integrity="sha512-sMgx0iqtQVrEwuUPBeRZE42fOPWIRBRb3CLaoK5gilEnzKTkdJpjguVk5HpcmOgjyZlHSGqXXugNlaovRhYLsg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"
        integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- include summernote css/js -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
        integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}" integrity=""></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}" integrity=""></script>
    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/responsive.bootstrap4.min.js') }}" integrity=""></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    {{-- <script src="../node_modules/simpleweather/jquery.simpleWeather.min.js"></script>
    <script src="../node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="../node_modules/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="../node_modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../node_modules/summernote/dist/summernote-bs4.js"></script>
    <script src="../node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script> --}}

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Page Specific JS File -->
    {{-- <script src="{{ asset('js/page/index-0.js') }}"></script> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session()->has('success'))
        <script>
            Swal.fire('Berhasil', '{{ session("success") }}', 'success');
        </script>
    @endif
    <script>    
        const currencyInput = function() {
            const value = event.target.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
            event.target.value = numeral(value).format('0,0');
        }    
        const userId = '{{ auth()->id() }}'
        const channel = window.Echo.channel('notifications'+userId);
        
        channel.listen('NotifEvent', function(data) {
            Swal.fire('Message', JSON.stringify(data.message), 'warning');
        });

        const logout = function (){
            document.getElementById('form-logout').submit()
        }

        $(document).ready(function() {
            $('#preloader').fadeOut();
            $('body').removeClass('no-scroll-y');
            $('.datatable').DataTable( {
                responsive: true
            });
            $('.select2').select2();

        });
    </script>
    <script>

    </script>
    @stack('scripts')
</body>
</html>
