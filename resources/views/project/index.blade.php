@extends('layouts.app')


@section('content')
    <div class="card">
        <div class="card-header">
            <h4>List Project</h4>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#createProject">Tambah Project</button>
            </div>
            <table class="table datatable">
                <thead>
                    <th>No</th>
                    <th>Nama Project</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach ($projects as $key => $project)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $project->name }}</td>
                            <td>
                                <a href="{{ route('project.task.index', $project->id) }}" class="btn btn-primary">Task</a>
                                <button class="btn btn-danger" type="button" onclick="destroy('{{ $project->id }}')">Delete</button>
                                <form action="{{ route("project.destroy", $project->id) }}" method="post" id="form-{{$project->id}}">
                                    @csrf
                                    @method('delete')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@push('modals')
    <div class="modal fade" id="createProject" tabindex="-1" aria-labelledby="createProjectLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('project.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProjectLabel">Tambah Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Project</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Nama Project">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Project</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="10" style="height: 100px"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush


@push('scripts')
    <script>
        $('form').submit(function(){
            event.preventDefault();

            const data = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data,
                success: function (res){
                    if(res.success){
                        location.reload()
                    }
                },
                error: function (err){
                    console.log(err);
                }
            })
        })

    function destroy (id){
        $('#form-'+id).submit();
    }
    </script>
@endpush