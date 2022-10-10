@extends('layouts.app')

@section('content')
<div class="row justify-content-center mb-5">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Edit Divisi</h4>
            </div>
            <form action="{{ route('divisi.update', $data->id) }}" method="post">
                @csrf
                @method('patch')
                <div class="card-body">
                    <div class="form-group">
                        <label for="divisi">Divisi</label>
                        <input type="text" name="divisi" class="form-control" id="divisi" value="{{ $data->divisi }}">
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Update</a>
                    </div>
                </div>
        </div>
    </div>
    </form>
</div>
@endsection