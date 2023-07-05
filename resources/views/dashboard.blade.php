@extends('layouts.app')

@section('third_party_stylesheets')
    <style>
        table#dashboard_jo_table thead th, table#dashboard_jo_table tbody td{
            text-align:center;
            vertical-align: middle;
        }
        
        td.dashboard_jo_table_hide_col{
            display:none;
        }

        @media (max-width:796px){
            table#dashboard_jo_table{
                font-size:0.9rem!important;
            }
        }
    </style>
@endsection

@section('content')        
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-6 pl-5 pr-3">
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-gmis-infobox text-white"><i class="fas fa-tools"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Add Technician</span>
                        </div>
                        <div class="info-box-content info-box-gmis">
                            <span class="info-box-text info-box-text-gmis">{{$technician_count[0]->number_of_technicians}}</span>
                        </div>
                    </div>
                    {{-- <div class="small-box" style="color: #fff!important;background-color: #66baf1;">
                        <div class="inner">
                            <h3>0</h3>
                            <p>TEST</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="{{ route('dashboard') }}" class="small-box-footer" style="color:#fff!important;">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div> --}}
                </div>
                <div class="col-md-6 col-6 pl-3 pr-5">                    
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-gmis-infobox text-white"><i class="fas fa-fan"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Add Services</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 pl-5 pr-5">
                    <div class="card card-outline card-gmis">
                        <div class="card-header">
                            <h3 class="card-title text-bold">Job Orders</h3>
                        </div>
                        
                        <div class="card-body">                            
                            <div class="datatable_scroll" style="position: relative; overflow: auto; width: 100%;">
                                <table id="dashboard_jo_table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="0%" style="display:none;">ID</th>
                                            <th width="10%">JO ID</th>
                                            <th width="10%">Booking ID</th>
                                            <th width="15%">Schedule Date</th>
                                            <th width="15%">Issued Date</th>
                                            <th width="0%" style="display:none;">Technician ID</th>
                                            <th width="25%">Technician</th>
                                            <th width="15%">Status</th>
                                            <th width="10%">
                                                <i class="fa fa-cog"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($current_jo_lists as $jo)
                                        <tr> 
                                            <td class="dashboard_jo_table_hide_col">{{$jo->jo_id}}</td>
                                            <td>{{$jo->job_order_id}}</td>
                                            <td>{{$jo->booking_id}}</td>
                                            <td>{{$jo->jo_schedule_date}}</td>
                                            <td>{{$jo->jo_issued_date}}</td>
                                            <td class="dashboard_jo_table_hide_col">{{$jo->technician_id}}</td>
                                            <td>{{$jo->technician_name}}</td>
                                            <td>
                                                {{-- <span class="badge badge-gmis {{($jo->jo_status == 'Accepted') ? 'bg-success' : 'bg-danger'}}">{{$jo->jo_status}}</span> --}}                                                
                                                @if($jo->jo_status == 'Accepted')
                                                    <span class="badge badge-gmis bg-success">{{$jo->jo_status}}<span>
                                                @elseif($jo->jo_status == 'In Queue')
                                                    <span class="badge badge-gmis bg-info">{{$jo->jo_status}}</span>
                                                @elseif($jo->jo_status == 'Postponed')
                                                    <span class="badge badge-gmis bg-warning">{{$jo->jo_status}}</span>
                                                @elseif($jo->jo_status == 'Cancelled')
                                                    <span class="badge badge-gmis bg-danger">{{$jo->jo_status}}</span>
                                                @endif
                                            </td>
                                            <td style="display: flex;justify-content: space-around;">
                                                <div class="row">
                                                    @if($jo->technician_id != '')
                                                        <button data-jo_id="{{$jo->job_order_id}}" class="view_jo_modal_button btn btn-sm btn-warning">
                                                            <i class="fas fa-eye"></i>
                                                        </button>   
                                                    @endif                                                
                                                </div>
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

            <div class="row mt-4">
                <div class="col-md-12 pl-5 pr-5">
                    <div class="card card-outline card-gmis">
                        <div class="card-header">
                            <h3 class="card-title text-bold">Reports/Daily Booking</h3>
                        </div>
                        
                        <div class="card-body">                            
                            <div class="chart">
                                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="row mt-4 pb-4">
                <div class="col-md-12 pl-5 pr-5">
                    <div class="card card-outline card-gmis">
                        <div class="card-header">
                            <h3 class="card-title text-bold">Activity</h3>
                        </div>
                        
                        <div class="card-body">
                            <div class="timeline">
                                @foreach($user_action_history as $action_history)
                                    <div>
                                        <i class="fas fa-circle-alt bg-gmis"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> {{$action_history->created_at_time}}</span> 
                                            {{-- timeline-header is created date --}}
                                            <h3 class="timeline-header">{{$action_history->created_at_date}}</h3>
                                            {{-- timeline-body is activity/description --}}
                                            <div class="timeline-body">
                                                {{$action_history->action_history_activity}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div class="modal fade" id="view_jo_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">View Job Order Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                    <div class="modal-body">
                        
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="job_order_id" class="col-form-label text-sm">Job Order ID</label>
                                    <input type="text" class="form-control form-control-sm" id="job_order_id" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="jo_issued_date" class="col-form-label text-sm">JO Issue Date</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_issued_date" readonly>
                                </div>
                            </div>
                            {{-- <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="booking_id" class="col-form-label text-sm">Booking ID</label>
                                    <input type="text" class="form-control form-control-sm" id="booking_id" readonly>
                                </div>
                            </div> --}}
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="jo_status" class="col-form-label text-sm">Status</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_status" readonly>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="text-sm">Schedule Information</h4>
                                </div>
                            </div>        
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="jo_service_name" class="col-form-label text-sm">Service Name</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_service_name" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="jo_schedule_date" class="col-form-label text-sm">JO Schedule Date</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_schedule_date" readonly>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="jo_schedule_start_time" class="col-form-label text-sm">JO Schedule Start Time</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_schedule_start_time" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="jo_schedule_end_time" class="col-form-label text-sm">JO Schedule Start Time</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_schedule_end_time" readonly>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="text-sm">Device Information</h4>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="jo_customer_device_brand_name" class="col-form-label text-sm">Device Brand</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_customer_device_brand_name" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="jo_customer_device_serial_number" class="col-form-label text-sm">Device Serial #</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_customer_device_serial_number" readonly>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="jo_customer_device_ac_type" class="col-form-label text-sm">AC Type</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_customer_device_ac_type" readonly>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="text-sm">Customer Information</h4>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="jo_customer_name_wtih_id" class="col-form-label text-sm">Customer Name (ID)</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_customer_name_wtih_id" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="jo_customer_address" class="col-form-label text-sm">Customer Address</label>
                                    <textarea type="text" class="form-control form-control-sm" id="jo_customer_address" rows="3" readonly style="resize:none;"></textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="jo_customer_contact_number" class="col-form-label text-sm">Customer Contact #</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_customer_contact_number" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="jo_customer_email_address" class="col-form-label text-sm">Customer Email Address</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_customer_email_address" readonly>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="text-sm">Technician Information</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="jo_technician_name_wtih_id" class="col-form-label text-sm">Technician Name (ID)</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_technician_name_wtih_id" readonly>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="jo_technician_contact_number" class="col-form-label text-sm">Technician Contact #</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_technician_contact_number" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="jo_technician_email_address" class="col-form-label text-sm">Technician Email Address</label>
                                    <input type="text" class="form-control form-control-sm" id="jo_technician_email_address" readonly>
                                </div>
                            </div>

                        </div>

                    </div>
                
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                    </div>
                
            </div>
        </div>
    </div>

@endsection

@section('third_party_scripts')
    <script type="module">
        function displayLoader(bol){
            document.getElementById("page-loader-wrapper").style.display = (bol) ? "block" : "none";
        };
        
        $('#dashboard_jo_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "ordering": false
        });

        // VIEW JOB ORDER
        $('#dashboard_jo_table').on('click', '.view_jo_modal_button', function() {
            var view_jo_id = $(this).closest('tr').find('td:eq(0)').text();
            var view_joborder_id = $(this).closest('tr').find('td:eq(1)').text();

            $.ajax({
                type: 'GET',
                url: 'get_joborder_info/'+view_jo_id+'/'+view_joborder_id,
                beforeSend: function(){
                    /* Show image container */
                    displayLoader(true);
                },
                success:function(data) {
                    console.log(data);

                    $('#job_order_id').val(data['detailed_joborder_information'][0]['job_order_id']);
                    $('#jo_issued_date').val(data['detailed_joborder_information'][0]['jo_issued_date']);
                    $('#jo_status').val(data['detailed_joborder_information'][0]['jo_status']);
                    
                    $('#jo_service_name').val(data['detailed_booking_schedule'][0]['service_name']);
                    $('#jo_schedule_date').val(data['detailed_joborder_information'][0]['jo_schedule_date']);
                    $('#jo_schedule_start_time').val(data['detailed_booking_schedule'][0]['start_time']);
                    $('#jo_schedule_end_time').val(data['detailed_booking_schedule'][0]['end_time']);
                    
                    $('#jo_customer_device_brand_name').val(data['detailed_joborder_information'][0]['customer_device_serial_number']);
                    $('#jo_customer_device_serial_number').val(data['detailed_joborder_information'][0]['customer_device_brand_name']);
                    $('#jo_customer_device_ac_type').val(data['detailed_joborder_information'][0]['ac_type_name']);

                    $('#jo_customer_name_wtih_id').val(data['detailed_joborder_information'][0]['customer_name'] +' (' + data['detailed_joborder_information'][0]['customer_id'] + ')');
                    $('#jo_customer_address').val(data['detailed_joborder_information'][0]['complete_customer_address']);
                    $('#jo_customer_contact_number').val(data['detailed_joborder_information'][0]['customer_contact_number']);
                    $('#jo_customer_email_address').val(data['detailed_joborder_information'][0]['customer_email_address']);
                    
                    $('#jo_technician_name_wtih_id').val(data['detailed_joborder_information'][0]['technician_name'] +' (' + data['detailed_joborder_information'][0]['technician_id'] + ')');
                    $('#jo_technician_contact_number').val(data['detailed_joborder_information'][0]['technician_contact_number']);
                    $('#jo_technician_email_address').val(data['detailed_joborder_information'][0]['technician_email_address']);

                    $('#view_jo_modal').modal('show');
                },
                complete:function(data){
                    /* Hide image container */
                    displayLoader(false);
                }
            });
        });

        var areaChartData = {
        labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
            {
                label               : 'Job Order',
                backgroundColor     : 'rgba(16,101,82,0.9)',
                borderColor         : 'rgba(16,101,82,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(16,101,82,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(16,101,82,1)',
                data                : [28, 48, 40, 19, 86, 27, 90]
            },
            {
                label               : 'Bookings',
                backgroundColor     : 'rgba(210, 214, 222, 1)',
                borderColor         : 'rgba(210, 214, 222, 1)',
                pointRadius         : false,
                pointColor          : 'rgba(210, 214, 222, 1)',
                pointStrokeColor    : '#c1c7d1',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data                : [65, 59, 80, 81, 56, 55, 40]
            },
        ]
        }

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false
        }

        new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
        })
    </script>
@endsection