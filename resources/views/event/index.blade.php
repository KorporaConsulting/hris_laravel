@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css"
    integrity="sha512-liDnOrsa/NzR+4VyWQ3fBzsDBzal338A1VfUpQvAcdt+eL88ePCOd3n9VQpdA0Yxi4yglmLy/AmH+Lrzmn0eMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .fc-today{
            background-color: #FFF3CD !important;
        }
    </style>
@endsection


@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h4>Calendar</h4>
    </div>
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>
@endsection

@push('modals')
    <div class="modal fade" id="detailEvent" tabindex="-1" aria-labelledby="detailEventLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action=" " method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailEventLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Created By: <b></b></label>
                        </div>
                        <div class="form-group">
                            <label for="">Deskripsi</label>
                            <textarea class="form-control" name="description" id="" cols="30" rows="10" style="height: 100px;"
                                readonly></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @can('event.update')
                            <button type="submit" class="btn btn-primary">Update</button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"
    integrity="sha512-iusSCweltSRVrjOz+4nxOL9OXh2UA0m8KdjsX8/KUUiJz+TCNzalwE0WE6dYTfHDkXuGuHq3W9YIhDLN7UNB0w=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/fullcalendar-rightclick.js') }}"></script>
<script>
            $('#detailEvent').on('click', 'textarea', function(){
                console.log($(this).prop('readonly', false));
                $('#detailEvent button[type=submit]').show()
            })

            $('#detailEvent form').submit(function(){
                event.preventDefault()
                const data  = $(this).serializeArray();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'PATCH',
                    data,
                    dataType: 'json',
                    success: function(res){
                        if(res.success){
                            $('#calendar').fullCalendar('refetchEvents')
                            toastr.success('Berhasil mengupdate event', 'Success');
                            $('#detailEvent').modal('hide');
                        }
                    }
                })
            })

            var calendar = $('#calendar').fullCalendar({
                    themeSystem: 'bootstrap4',
                    editable: true,
                    displayEventTime: true,
                    events: window.location.href,
                    eventLimit: true,
                    // dayRightclick: function(date, jsEvent, view) {
                    //     alert('a day has been rightclicked!');
                    // // Prevent browser context menu:
                    // return false;
                    // },
                    eventRightclick: function(event, jsEvent, view) {
                        @if (auth()->user()->can("event.delete"))
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
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('event.action')  }}",
                                        data: {
                                                _token: '{{ csrf_token() }}',
                                                id: event.id,
                                                type: 'delete'
                                        },
                                        success: function (response) {
                                            calendar.fullCalendar('removeEvents', event.id);
                                            displayMessage("Event Deleted Successfully");
                                        },
                                        error: function(err){
                                            toastr.error('Tidak dapat menghapus event', "Failed")
                                        }
                                    });
                                }
                            })
                        @endif
                        return false;
                    },
                    // dayPopoverFormat: 't',
                    eventColor: 'royalblue',
                    timeFormat: 'H(:mm)',
                    header:{
                        left: 'agendaDay,agendaWeek,month',
                        center: 'title',
                        right: 'today prev,next'
                    },
                    // eventBackgroundColor: 'black',
                    displayEventTime: false,
                    editable: true,
                    eventRender: function (event, element, view) {
                        if (event.allDay === 'true') {
                                event.allDay = true;
                        } else {
                                event.allDay = false;
                        }
                    },
                    selectable: '{{ auth()->user()->can("event.create") }}',
                    selectHelper: true,
                    select: function (start, end, allDay) {
                        
                        Swal.fire({
                            // title: 'Are you sure?',
                            title: "Nama event",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Buat',
                            cancelButtonText: 'Batal',
                            input: 'text',
                            inputPlaceholder: 'Judul',
                            inputAttributes: {
                                required: 'true'
                            },
                        }).then((result) => {
                            const title = result.value
                            if (result.isConfirmed) {
                                start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm");
                                end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm");

                                $.ajax({
                                    url: "{{ route('event.action')  }}",
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        title,
                                        start,
                                        end,
                                        type: 'add'
                                    },
                                    type: "POST",
                                    success: function (data) {
                                        displayMessage("Event Created Successfully");
    
                                        calendar.fullCalendar('renderEvent',
                                            {
                                                id: data.id,
                                                title,
                                                start,
                                                end,
                                                allDay: allDay
                                            },true);
    
                                        calendar.fullCalendar('unselect');
                                    }
                                });
                            }
                        })

                    },
                    eventDrop: function (event, delta) {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
  
                        $.ajax({
                            url: "{{ route('event.action')  }}",
                            data: {
                                    _token: '{{ csrf_token() }}',
                                title: event.title,
                                start: start,
                                end: end,
                                id: event.id,
                                type: 'update'
                            },
                            type: "POST",
                            success: function (response) {
                                console.log(response);
                                displayMessage("Event Updated Successfully");
                            },
                            error: function(err){
                                console.log(err);
                                toastr.error('Tidak dapat mengupdate event', "Failed")
                            }

                        });
                    },
                    eventClick: function (event) {
                        console.log(event);
                        let url = "{{ route('event.update', ':id') }}";
                        url = url.replace(':id', event.id)
                        $('#detailEventLabel').html(event.title);
                        $('#detailEvent b').html(event.user.name);
                        $('#detailEvent form').attr('action', url);
                        $('#detailEvent textarea').prop('readonly', true).val(event.description ?? '-');
                        $('#detailEvent button[type=submit]').hide();
                        $('#detailEvent').modal('show');
                    }, 
                    // eventRender: function (event, element, view) {
                    //     element.find('.fc-title').append('<div class="hr-line-solid-no-margin"></div><span style="font-size: 10px">' +event.user.name + '</span></div>');
                    // },
                });
 
 
function displayMessage(message) {
    
    toastr.success(message, 'Event');
} 
    
</script>
@endpush