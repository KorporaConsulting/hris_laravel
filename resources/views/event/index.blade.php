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
{{-- <div class="card">
    <div class="card-header">
        <h4>List Hari Ini</h4>
    </div>
    <div class="card-body">
        @forelse ($events as $event)
            
        @empty
            <div class="alert alert-warning">Tidak ada event hari ini</div>
        @endforelse
    </div>
</div> --}}
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"
    integrity="sha512-iusSCweltSRVrjOz+4nxOL9OXh2UA0m8KdjsX8/KUUiJz+TCNzalwE0WE6dYTfHDkXuGuHq3W9YIhDLN7UNB0w=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

            var calendar = $('#calendar').fullCalendar({
                    themeSystem: 'bootstrap4',
                    editable: true,
                    displayEventTime: true,
                    events: window.location.href,
                    eventColor: 'royalblue',
                    eventMouseover: function( event, jsEvent, view ) {
                        console.log(jsEvent.target)
                        // $(jsEvent.target).tooltip('enable')
                        // $(jsEvent.target).hide()
                        console.log(event)
                        // console.log(jsEvent)
                        // console.log(view)
                    },
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
                    selectable: true,
                    selectHelper: true,
                    select: function (start, end, allDay) {
                        
                        Swal.fire({
                            // title: 'Are you sure?',
                            text: "Nama event",
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
                        // var title = prompt('Event Title:');
                        // if (title) {
                        //     var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm");
                        //     var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm");
                        //     $.ajax({
                        //         url: "{{ route('event.action')  }}",
                        //         data: {
                        //                 _token: '{{ csrf_token() }}',
                        //             title: title,
                        //             start: start,
                        //             end: end,
                        //             type: 'add'
                        //         },
                        //         type: "POST",
                        //         success: function (data) {
                        //             displayMessage("Event Created Successfully");
  
                        //             calendar.fullCalendar('renderEvent',
                        //                 {
                        //                     id: data.id,
                        //                     title: title,
                        //                     start: start,
                        //                     end: end,
                        //                     allDay: allDay
                        //                 },true);
  
                        //             calendar.fullCalendar('unselect');
                        //         }
                        //     });
                        // }
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
                            }

                        });
                    },
                    eventClick: function (event) {
                        var deleteMsg = confirm("Do you really want to delete?");
                        if (deleteMsg) {
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
                                }
                            });
                        }
                    }
 
                });
 
 
function displayMessage(message) {
    
    toastr.success(message, 'Event');
} 
    
</script>
@endpush