@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <figure class="avatar mr-2 avatar-xl">
                                <img src="/img/avatar/avatar-1.png" alt="...">
                            </figure>
                        </div>
                        <div class="col-12 col-lg-9">
                            <div class="row">
                                <div class="col-6 mb-3">
                                        <div class="font-weight-bold">Name</div>
                                        <div>{{ auth()->user()->name }}</div>
                                    </div>
                                <div class="col-6 mb-3">
                                    <div class="font-weight-bold">Nomor Telepon</div>
                                    <div>{{ $user->no_hp }}</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="font-weight-bold">Divisi</div>
                                    <div>{{ auth()->user()->divisi }}</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="font-weight-bold">Status</div>
                                    <div>{{ $user->status_user }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection