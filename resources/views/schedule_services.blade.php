@extends('layouts.app')

@section('third_party_stylesheets')
    <style>
        table#services_schedule_table thead th, table#services_schedule_table tbody td{
            text-align:center;
            vertical-align: middle;
        }
        
        td.services_schedule_table_hide_col{
            display:none;
        }
        
        @media (max-width:796px){
            table#services_schedule_table{
                font-size:0.9rem!important;
            }
        }
    </style>
@endsection

@section('content')        
    <section class="content">
        <div class="container-fluid">
            
            <div class="row mt-4">
                <div class="col-md-12 pl-5 pr-5">
                    <div class="card card-outline card-gmis">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-calendar" style="box-shadow:none;">
                                    <div class="card-body p-3">
                                        <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 pl-5 pr-5">
                    <div class="card card-outline card-gmis">
                        <div class="card-header">                            
                            <h3 class="card-title text-bold">Services Schedule List</h3>
                            <div class="card-tools">                                
                                <button class="btn btn-primary-gmis" data-toggle="modal" data-target="#add_services_schedule_modal"><i class="fas fa-plus"></i> Add Schedule</button>
                            </div>
                        </div>
                        <div class="card-body">    

                            <div class="datatable_scroll" style="position: relative; overflow: auto; width: 100%;">
                                <table id="services_schedule_table" class="table table-bordered table-hover mb-2">
                                    <thead>
                                        <tr>
                                            <th width="0%" style="display:none;">Partner Schedule ID</th>
                                            <th width="0%" style="display:none;">Service ID</th>
                                            <th width="25%">Service Name</th>
                                            <th width="0%" style="display:none;">Schedule Date Not Formatted</th>
                                            <th width="25%">Schedule Date</th>
                                            <th width="0%" style="display:none;">Start Time</th>
                                            <th width="0%" style="display:none;">End Time</th>
                                            <th width="30%">Time</th>
                                            <th width="10%">Slots Available</th>
                                            <th width="10%">
                                                <i class="fa fa-cog"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($partner_schedule_list as $partner_schedule)
                                        <tr>
                                            <td class="services_schedule_table_hide_col">{{$partner_schedule->partner_sched}}</td>
                                            <td class="services_schedule_table_hide_col">{{$partner_schedule->partner_service_id}}</td>
                                            <td>{{$partner_schedule->service_name}}</td>
                                            <td>{{$partner_schedule->schedule_date}}</td>
                                            <td class="services_schedule_table_hide_col">{{$partner_schedule->partner_schedule_date}}</td>
                                            <td class="services_schedule_table_hide_col">{{$partner_schedule->partner_schedule_start_time}}</td>
                                            <td class="services_schedule_table_hide_col">{{$partner_schedule->partner_schedule_end_time}}</td>
                                            <td>{{$partner_schedule->start_time}} - {{$partner_schedule->end_time}}</td>
                                            <td>{{$partner_schedule->partner_schedule_no_of_slots}}</td>
                                            <td class="pr-5 pl-5">
                                                <button data-partner_schedule_id="{{$partner_schedule->partner_sched}}" data-partner_schedule_id="{{$partner_schedule->partner_sched}}" class="edit_services_schedule_button btn btn-sm btn-primary-gmis">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>  

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div class="modal fade" id="edit_services_schedule_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Services Schedule</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="edit_services_schedule_form" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">     

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="edit_partner_schedule_date" class="col-form-label">Schedule Date</label>
                                                <input type="text" class="form-control form-control-sm" id="edit_partner_sched" name="edit_partner_sched" hidden>
                                                <input type="text" class="form-control form-control-sm" id="edit_partner_service_id" name="edit_partner_service_id" hidden>
                                                <input type="text" class="form-control form-control-sm datetimepicker-input" id="edit_partner_schedule_date" name="edit_partner_schedule_date"  data-toggle="datetimepicker" data-target="#edit_partner_schedule_date">
                                            </div>
                                        </div>    
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="edit_partner_schedule_slots" class="col-form-label">Schedule Slots</label>
                                                <input type="number" class="form-control form-control-sm" id="edit_partner_schedule_slots" name="edit_partner_schedule_slots" placeholder="Enter Schedule Slots">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="edit_partner_service_start_time" class="col-form-label">Schedule Start Time</label>
                                                <input type="text" class="form-control form-control-sm datetimepicker-input" id="edit_partner_schedule_start_time" name="edit_partner_schedule_start_time"  data-toggle="datetimepicker" data-target="#edit_partner_schedule_start_time">
                                            </div>
                                        </div>    
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="edit_partner_schedule_end_time" class="col-form-label">Schedule End Time</label>
                                                <input type="text" class="form-control form-control-sm datetimepicker-input" id="edit_partner_schedule_end_time" name="edit_partner_schedule_end_time"  data-toggle="datetimepicker" data-target="#edit_partner_schedule_end_time">
                                            </div>
                                        </div>
                                    </div>
                                                                                                             
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_edit_services_schedule" class="btn btn-primary-gmis">Edit Schedule</button>
                    </div>
                
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_services_schedule_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Services Schedule</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="add_services_schedule_form" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">    
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="add_partner_service_name" class="col-form-label">Service</label>
                                                <select class="form-control form-control-sm select2" id="add_partner_service_id" name="add_partner_service_id" style="width: 100%;">
                                                    @foreach($partner_services_list as $services_list)
                                                        <option value="{{$services_list->partner_service_id}}">{{$services_list->service_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="add_partner_schedule_date" class="col-form-label">Schedule Date</label>
                                                <input type="text" class="form-control form-control-sm datetimepicker-input" id="add_partner_schedule_date" name="add_partner_schedule_date"  data-toggle="datetimepicker" data-target="#add_partner_schedule_date">
                                                {{-- <input type="text" name="daterange" class="form-control form-control-sm" id="add_partner_schedule_date"/> --}}
                                            </div>
                                        </div>    
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="add_partner_schedule_slots" class="col-form-label">Schedule Slots</label>
                                                <input type="number" class="form-control form-control-sm" id="add_partner_schedule_slots" name="add_partner_schedule_slots" placeholder="Enter Schedule Slots">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="add_partner_schedule_start_time" class="col-form-label">Schedule Start Time</label>
                                                <input type="text" class="form-control form-control-sm datetimepicker-input" id="add_partner_schedule_start_time" name="add_partner_schedule_start_time"  data-toggle="datetimepicker" data-target="#add_partner_schedule_start_time">
                                            </div>
                                        </div>    
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="add_partner_schedule_end_time" class="col-form-label">Schedule End Time</label>
                                                <input type="text" class="form-control form-control-sm datetimepicker-input" id="add_partner_schedule_end_time" name="add_partner_schedule_end_time"  data-toggle="datetimepicker" data-target="#add_partner_schedule_end_time">
                                            </div>
                                        </div>
                                    </div>
                                                                                                             
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_add_services_schedule" class="btn btn-primary-gmis">Add Schedule</button>
                    </div>
                
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewSchedule" tabindex="-1" role="dialog" aria-labelledby="viewSchedule" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Schedule for the day: <span id="sched"></span></h5>
                </div>
                <div class="modal-body" style="text-align:center;">
                    <ul class="list-group" id="view_listing">
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
            
@endsection

@section('third_party_scripts')
    <script type="module">        
        function displayLoader(bol){
            document.getElementById("page-loader-wrapper").style.display = (bol) ? "block" : "none";
        }
        
        $('#services_schedule_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "ordering": false
        });
        
        var today = new Date();
        var curr_date = today.getFullYear()+'-'+('0' + (today.getMonth()+1)).slice(-2)+'-'+('0' + today.getDate()).slice(-2);
        var vList = $('ul#view_listing');
        const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];

        var partner_schedule_count = {!! json_encode($partner_schedule_count) !!}; 
        var services_schedules_events = [];

        console.log(partner_schedule_count);

        partner_schedule_count.forEach(function(element, index){
            if(curr_date > element.partner_schedule_date){
                services_schedules_events.push({
                    title: element.total_schedule_slots,
                    start: element.partner_schedule_date,
                    end: element.partner_schedule_date,
                    display: 'background',
                    color: 'rgba(131, 146, 171, 0.4)'
                }); 
            }else{
                services_schedules_events.push({
                    title: element.total_schedule_slots,
                    start: element.partner_schedule_date,
                    end: element.partner_schedule_date,
                    display: 'background',
                    color: '#8fdf82'
                }); 
            }
            
            console.log(curr_date)        
            console.log(element.partner_schedule_date)
        });


        var calendarEl = document.getElementById('calendar');
        var calendar = new Calendar(calendarEl, {
            plugins: [window.interaction, window.dayGridPlugin, window.timeGridPlugin, window.listPlugin, window.multiMonth, window.bootstrapPlugin],
            contentHeight: 'auto',
            dayMaxEventRows: 3,
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap',
            height: 650,
            selectable: false,
            editable: false,
            dateClick: function(info) {    

                $.ajax({
                    type: 'GET',
                    url: 'get_events/'+info.dateStr,
                    beforeSend: function(){
                        /* Show image container */
                        displayLoader(true);
                    },
                    success:function(data) {
                        console.log(data);
                        vList.empty();
                        if(data.length == 0 ){
                            var li = $('<li class="list-group-item text-white" style="background-image:linear-gradient(310deg,#c0c5ce,#4f5b66);border:none;"/>')
                                        .appendTo(vList);
                            var aaa = $('<span/>', {
                                text : "NO SERVICE SCHEDULED FOR THIS DAY."})
                                .appendTo(li);
                        }else{
                            $.each(data, function(i) {
                                if(data[i].partner_schedule_no_of_slots < 1){
                                    var li = $('<li class="list-group-item" style="background-color:red;"/>')
                                        .appendTo(vList);
                                }else{
                                    var li = $('<li class="list-group-item"/>')
                                        .appendTo(vList);
                                }
                                var aaa = $('<span/>', {
                                    // text : data[i].start_time + ' - ' + data[i].end_time + ' | Slots: ' + ((data[i].remaining_slots > 0) ? data[i].remaining_slots : 0) + '/' + ((data[i].no_of_slots < 2) ? 2 : data[i].no_of_slots)})
                                    text : data[i].service_name + ' - ' + data[i].start_time + ' - ' + data[i].end_time + ' | Slots Available: ' + data[i].partner_schedule_no_of_slots
                                }).appendTo(li);
                            });
                        }
                        
                        var date_clicked = new Date(info.dateStr);
                        $("#sched").html(month[date_clicked.getMonth()] + " " + date_clicked.getDate() + ", " + date_clicked.getFullYear());            

                        $('#viewSchedule').modal('show');
                    },
                    complete:function(data){
                        /* Hide image container */
                        displayLoader(false);
                    }
                });
            },
            eventContent: function(info){
                // return { html: '<h3 style="color:black;padding-left:10px">' + info.event.title + '</h3>' };
                return { html: '<span class="badge bg-gradient-dark" style="color:#fff;padding:5px 7px;margin-left:2px;" id="calendar_badge">' + info.event.title + '</span>' };
            },
            events: services_schedules_events
        });

        calendar.render();

        $('#services_schedule_table').on('click', '.edit_services_schedule_button', function() {
            var edit_partner_sched = $(this).closest('tr').find('td:eq(0)').text();
            var edit_partner_service_id = $(this).closest('tr').find('td:eq(1)').text();
            var edit_partner_service_name = $(this).closest('tr').find('td:eq(2)').text();
            var edit_partner_schedule_date = $(this).closest('tr').find('td:eq(4)').text();
            var edit_partner_schedule_start_time = $(this).closest('tr').find('td:eq(5)').text();
            var edit_partner_schedule_end_time = $(this).closest('tr').find('td:eq(6)').text();
            var edit_partner_schedule_slots = $(this).closest('tr').find('td:eq(8)').text();
            
            $('#edit_partner_sched').val(edit_partner_sched);
            $('#edit_partner_service_id').val(edit_partner_service_id);
            $('#edit_partner_schedule_date').val(edit_partner_schedule_date);
            $('#edit_partner_schedule_start_time').val(edit_partner_schedule_start_time);
            $('#edit_partner_schedule_end_time').val(edit_partner_schedule_end_time);
            $('#edit_partner_schedule_slots').val(edit_partner_schedule_slots);

            $('#edit_services_schedule_modal').modal('show');
        });

        $('#edit_partner_schedule_date').datetimepicker({
            format: 'YYYY-MM-DD'
        }); 

        $('#edit_partner_schedule_start_time').datetimepicker({
            format: 'HH:mm:ss'
        });
        
        $('#edit_partner_schedule_end_time').datetimepicker({
            format: 'HH:mm:ss'
        });

        // Edit Services form
        $("#edit_services_schedule_form").validate({
            rules: {
                edit_partner_sched: {
                    required: true,
                },
                edit_partner_service_id: {
                    required: true,
                },
                edit_partner_schedule_date: {
                    required: true,
                },
                edit_partner_schedule_start_time: {
                    required: true,
                },
                edit_partner_schedule_end_time: {
                    required: true,
                },
                edit_partner_schedule_slots: {
                    required: true,
                }
            },
            messages: {
                edit_partner_sched: {
                    required: "This field is required.",
                },
                edit_partner_service_id: {
                    required: "This field is required.",
                },
                edit_partner_schedule_date: {
                    required: "This field is required.",
                },
                edit_partner_schedule_start_time: {
                    required: "This field is required.",
                },
                edit_partner_schedule_end_time: {
                    required: "This field is required.",
                },
                edit_partner_schedule_slots: {
                    required: "This field is required.",
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group .col-input').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form, e) {
                e.preventDefault();
                var services_schedule_update_form = $(form).serialize();

                swal.fire({
                    title: "Continue updating service schedule?",
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, continue!",
                    confirmButtonColor: '#007bff',
                    cancelButtonText: "No, wait go back!",
                    reverseButtons: !0
                }).then(function (e) {
                    if(e.value === true){
                        services_schedule_update(services_schedule_update_form);
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        });

        function services_schedule_update(services_schedule_update_form){
            $.ajax({
                url: 'services_schedule_update',
                type: "POST",
                data: services_schedule_update_form,
                dataType: "json",
                success: function( response ){
                    console.log(response);
                    
                    if(response.success_flag == 0){
                        toastr.error(response.message)
                    }else{
                        toastr.success(response.message);

                        setTimeout(function(){
                            window.location.reload();
                        }, 2000);
                    }
                },
                error: function( response ){
                    console.log("Error: " + response);
                }
            });
        }

        // $('#add_partner_schedule_date').daterangepicker();
        $('#add_partner_schedule_date').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#add_partner_schedule_start_time').datetimepicker({
            format: 'HH:mm:00'
        });
        
        $('#add_partner_schedule_end_time').datetimepicker({
            format: 'HH:mm:00'
        });
        
        $('#add_partner_service_id').select2();

        // Add Services form
        $("#add_services_schedule_form").validate({
            rules: {
                add_partner_service_id: {
                    required: true,
                },
                add_partner_schedule_date: {
                    required: true,
                },
                add_partner_schedule_slots: {
                    required: true,
                },
                add_partner_schedule_start_time: {
                    required: true,
                },
                add_partner_schedule_end_time: {
                    required: true,
                }
            },
            messages: {
                add_partner_service_id: {
                    required: "This field is required.",
                },
                add_partner_schedule_date: {
                    required: "This field is required.",
                },
                add_partner_schedule_slots: {
                    required: "This field is required.",
                },
                add_partner_schedule_start_time: {
                    required: "This field is required.",
                },
                add_partner_schedule_end_time: {
                    required: "This field is required.",
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group .col-input').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form, e) {
                e.preventDefault();
                var services_schedule_add_form = $(form).serialize();

                swal.fire({
                    title: "Continue adding service schedule?",
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, continue!",
                    confirmButtonColor: '#007bff',
                    cancelButtonText: "No, wait go back!",
                    reverseButtons: !0
                }).then(function (e) {
                    if(e.value === true){
                        services_schedule_add(services_schedule_add_form);
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        });

        function services_schedule_add(services_schedule_add_form){
            $.ajax({
                url: 'services_schedule_add',
                type: "POST",
                data: services_schedule_add_form,
                dataType: "json",
                success: function( response ){
                    console.log(response);
                    
                    if(response.success_flag == 0){
                        toastr.error(response.message)
                    }else{
                        toastr.success(response.message);

                        setTimeout(function(){
                            window.location.reload();
                        }, 2000);
                    }
                },
                error: function( response ){
                    console.log("Error: " + response);
                }
            });
        }

    </script>
@endsection