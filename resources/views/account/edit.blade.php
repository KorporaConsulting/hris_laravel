@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css"
    integrity="sha512-0SPWAwpC/17yYyZ/4HSllgaK7/gg9OlVozq8K7rf3J8LvCjYEEIfzzpnA2/SSjpGIunCSD18r3UhvDcu/xncWA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
        /* Ensure the size of the image fit the container perfectly */
        #image {
        display: block;
        
        /* This rule is very important, please don't ignore this */
        max-width: 100%;
        }

        .image_area {
        position: relative;
        }
        
        #upload_image {
        display: block;
        max-width: 100%;
        }
        
        .preview {
        overflow: hidden;
        width: 160px;
        height: 160px;
        margin: 10px;
        border: 1px solid red;
        }
        
        .modal-lg{
        max-width: 1000px !important;
        }
        
        .overlay {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        background-color: rgba(255, 255, 255, 0.5);
        overflow: hidden;
        height: 0;
        transition: .5s ease;
        width: 100%;
        }
        
        .image_area:hover .overlay {
        height: 50%;
        cursor: pointer;
        }
        
        .text {
        color: #333;
        font-size: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('account.update') }}" method="post">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="oldImage" value="{{ $user->img }}">
                    <input type="hidden" name="newProfile" id="newProfile">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="email">Nama</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ auth()->user()->email }}">
                            </div>
                            <div class="form-group">
                                <label for="tmpt_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control" name="tmpt_lahir" id="tmpt_lahir" value="{{ $user->tmpt_lahir }}">
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" value="{{ $user->tgl_lahir }}">
                            </div>
                            <div class="form-group">
                                <label for="alamat_ktp">Alamat KTP</label>
                                <input type="text" class="form-control" name="alamat_ktp" id="alamat_ktp" value="{{ $user->alamat_ktp }}">
                            </div>
                            <div class="form-group">
                                <label for="alamat_domisili">Alamat Domisili</label>
                                <textarea class="form-control" id="alamat_domisili" cols="30" rows="10" name="alamat_domisili" style="height: 100px;">{{ $user->alamat_domisili }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="no_hp">Momor Telepon/HP</label>
                                <input type="number" class="form-control" name="no_hp" id="no_hp" value="{{ $user->no_hp }}">
                            </div>
                            <div class="form-group">
                                <label for="no_hp_darurat">Momor Telepon/HP (Darurat)</label>
                                <input type="number" class="form-control" name="no_hp_darurat" id="no_hp_darurat" value="{{ $user->no_hp_darurat }}">
                            </div>
                            <div class="form-group">
                                <label for="divisi">Divisi</label>
                                <select name="divisi" id="divisi" class="form-control" readonly>
                                    @foreach ($divisi as $value)
                                        <option value="{{ $value->id }}" {{ $value->id == auth()->user()->divisi_id ? 'selected' : '' }}>{{ $value->divisi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{ $user->jabatan }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="row">
                                {{-- <div class="col-md-4">&nbsp;</div> --}}
                                <div class="col-md-12">
                                    <div class="image_area">
                                        <label for="upload_image">
                                            <img src="{{ asset('storage/' . auth()->user()->img) }}" id="uploaded_image" class="img-responsive img-circle" />
                                            <div class="overlay">
                                                <div class="text">Click to Change Profile Image</div>
                                            </div>
                                            <input type="file" class="image" id="upload_image" style="display:none" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('modals')
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image Before Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img src="" id="sample_image" />
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="crop" class="btn btn-primary">Crop</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
 @endpush


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"
        integrity="sha512-ooSWpxJsiXe6t4+PPjCgYmVfr1NS5QXJACcR/FPpsdm6kqG1FmQ2SVyg2RXeVuCRBLr0lWHnWJP6Zs1Efvxzww=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function(){

            var $modal = $('#modal');

            var image = document.getElementById('sample_image');

            var cropper;

            $('#upload_image').change(function(event){
                var files = event.target.files;

                var done = function(url){
                    image.src = url;
                    $modal.modal('show');
                };

                if(files && files.length > 0)
                {
                    reader = new FileReader();
                    reader.onload = function(event)
                    {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 3,
                    preview:'.preview'
                });
            }).on('hidden.bs.modal', function(){
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function(){
                canvas = cropper.getCroppedCanvas({
                    width:400,
                    height:400
                });

                canvas.toBlob(function(blob){
                    url = URL.createObjectURL(blob);
                    console.log(url)
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function(){
                        var base64data = reader.result;
                        console.log(base64data);
                        $modal.modal('hide');
                        $('#uploaded_image').attr('src', base64data);
                        $('#newProfile').val(base64data);
                    };
                });
            });  
        });
    </script>
@endpush