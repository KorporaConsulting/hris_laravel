@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Change Password</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('account.updatePassword') }}" method="post">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label for="">Password Saat Ini</label>
                        <input type="password" class="form-control @error('oldPassword') is-invalid @enderror" id="oldPassword" name="oldPassword" placeholder="Password saat ini">
                        @error('oldPassword')
                            <div class="invalid-feedback">
                               {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Password Baru</label>
                        <input type="password" class="form-control @error('newPassword') is-invalid @enderror"" id="newPassword" name="newPassword" placeholder="Password baru">
                        @error('newPassword')
                            <div class="invalid-feedback">
                               {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Konfimasi Password Baru</label>
                        <input type="password" class="form-control" id="newPassword_confirmation" name="newPassword_confirmation" placeholder="Konfirmasi Password Baru">
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection