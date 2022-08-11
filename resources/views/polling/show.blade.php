@extends('layouts.app')


@section('content')
<div class="row justify-content-center">
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