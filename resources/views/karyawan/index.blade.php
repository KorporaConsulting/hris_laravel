@extends('layouts.app')



@section('content')
@if ($errors->any())
    <div class="alert" style="background-color: #ff7675">
        <h4>Message</h4>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>List Karyawan</h4>
            </div>
            <div class="card-body">
                <div class="mb-3 text-right">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#bulkInsert">Bulk
                        Insert (CSV)</button>
                </div>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Status Pekerja</th>
                            <th>Jabatan</th>
                            <th>Divisi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                @if ($user->karyawan->is_active > 0)
                                <span class="badge badge-success">Aktif</span>
                                @else
                                <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>{{ $user->karyawan->jabatan}}</td>
                            <td>{{ $user->divisi->divisi ?? '-'}}</td>
                            <td>
                                @can('karyawan.update')
                                    <a href="{{ route('karyawan.edit', $user->id) }}" class="btn btn-success">Edit</a>
                                @endcan
                                <a href="{{ route('karyawan.kpi.index', $user->id) }}" class="btn btn-primary">Lihat
                                    KPI</a>
                                <a href="{{ route('karyawan.changeStatus', [$user->id, 'status' => $user->karyawan->is_active]) }}" class="btn btn-warning" title="Ubah Status Keaktifan"><i class="fas fa-sync-alt"></i></a>
                                <a href="{{ route('project.index', ['user_id' => $user->id]) }}" class="btn btn-primary" title="Lihat Task"><i class="fas fa-tasks"></i></a>
                                @can('karyawan.delete')
                                    <button class="btn btn-danger" type="button" onclick="destroy({{$user->id}})" title="Hapus Karyawan"><i class="fas fa-trash-alt"></i></button>
                                @endcan
                                <form action="{{ route('karyawan.destroy', $user->id) }}" method="post" id="form-{{$user->id}}">
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
    </div>
</div>
@endsection


@push('modals')
<!-- Modal -->
<div class="modal fade" id="bulkInsert" tabindex="-1" aria-labelledby="bulkInsertLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('karyawan.csvStore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkInsertLabel">Bulk Insert</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file" class="form-label">File (CSV)</label>
                        <input type="file" name="file" id="csv" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <label for="file" class="form-label">Template</label>
                        <div><a href="{{ asset('template_bulk_insert.csv') }}" class="btn btn-primary">Download</a></div>
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
    function destroy (id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $('#form-'+id).submit();
            }
        })
    }
</script>
{{-- <script>
    function CSVToArray(CSV_string, delimiter) {
            delimiter = (delimiter || ","); // user-supplied delimeter or default comma

            var pattern = new RegExp( // regular expression to parse the CSV values.
                ( // Delimiters:
                    "(\\" + delimiter + "|\\r?\\n|\\r|^)" +
                    // Quoted fields.
                    "(?:\"([^\"]*(?:\"\"[^\"]*)*)\"|" +
                    // Standard fields.
                    "([^\"\\" + delimiter + "\\r\\n]*))"
                ), "gi"
            );

            var rows = [
                []
            ]; // array to hold our data. First row is column headers.
            // array to hold our individual pattern matching groups:
            var matches = false; // false if we don't find any matches
            // Loop until we no longer find a regular expression match
            while (matches = pattern.exec(CSV_string)) {
                var matched_delimiter = matches[1]; // Get the matched delimiter
                // Check if the delimiter has a length (and is not the start of string)
                // and if it matches field delimiter. If not, it is a row delimiter.
                if (matched_delimiter.length && matched_delimiter !== delimiter) {
                    // Since this is a new row of data, add an empty row to the array.
                    rows.push([]);
                }
                var matched_value;
                // Once we have eliminated the delimiter, check to see
                // what kind of value was captured (quoted or unquoted):
                if (matches[2]) { // found quoted value. unescape any double quotes.
                    matched_value = matches[2].replace(
                        new RegExp("\"\"", "g"), "\""
                    );
                } else { // found a non-quoted value
                    matched_value = matches[3];
                }
                // Now that we have our value string, let's add
                // it to the data array.
                rows[rows.length - 1].push(matched_value);
            }
            return rows; // Return the parsed data Array
        }
        let data = [];
        var fileInput = document.getElementById("csv"),

            readFile = function() {
                var reader = new FileReader();
                reader.onload = function() {

                    data = CSVToArray(reader.result)

                };
                // start reading the file. When it is done, calls the onload event defined above.
                reader.readAsBinaryString(fileInput.files[0]);
            };

        fileInput.addEventListener('change', readFile);

        // const previewCsv = function() {
        //     const input = parseInt(document.getElementById('input').value);
        //     if (data.length > input) {
        //         data = data.splice(0, input);
        //     }
        //     let html = '';
        //     data.forEach(e => {
        //         html += `
        //                     <tr>
        //                         <td>${e[0]}</td>
        //                         <td>${e[1]}</td>
        //                         <td>${e[2]}</td>
        //                         <td>${e[3]}</td>
        //                     </tr>
        //                 `;
        //     })

        //     document.querySelector('tbody').innerHTML = html;
        // } 


        // $('form').submit(function(e) {
        //     event.preventDefault();
        //     console.log(data);
        //     if (data.length > input) {
        //         data = data.splice(0, input);
        //     }
        // data = data.map
            // const input = parseInt(document.getElementById('input').value);

            // if (data.length > input) {
            //     data = data.splice(0, input);
            // }

            // $.ajax({
            //     url: $(this).attr('action'),
            //     method: 'POST',
            //     dataType: 'json',
            //     data: {
            //         data,
            //     },
            //     success: function(res) {
            //         console.log(res);
            //         if (res.success) {
            //             window.location.href = res.redirect;
            //         }
            //     },
            //     error: function() {

            //     }

            // })
        })
</script> --}}
{{-- <script>
    $('form').submit(function(){
                event.preventDefault();
        
                const formData = new FormData($(this)[0]);
        
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    success: function (response) {
                        console.log(response)
                        alert(response);
                    },
                    error: function(err){
                        console.log(err)
                    }
                });
            })
</script> --}}

@endpush