@extends('layouts.app')

@section('third_party_stylesheets')
    <style>
        table#joborder_table thead th, table#joborder_table tbody td, table#booking_table thead th, table#booking_table tbody td, table#booking_schedule_table thead th, table#booking_schedule_table tbody td{
            text-align:center;
            vertical-align: middle;
        }
        
        td.joborder_table_hide_col, td.booking_table_hide_col{
            display:none;
        }

        @media (max-width:796px){
            table#joborder_table, table#booking_table, table#booking_schedule_table{
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
                        <div class="card-header">                            
                            <h3 class="card-title text-bold">Available Bookings</h3>
                        </div>
                        <div class="card-body">   

                            <div class="datatable_scroll" style="position: relative; overflow: auto; width: 100%;">
                                <table id="booking_table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="0%" style="display:none;">ID</th>
                                            <th width="10%">Booking ID</th>
                                            <th width="10%">AC Type</th>
                                            <th width="20%">Service Type</th>
                                            <th width="20%">Booking Date</th>
                                            <th width="0%" style="display:none;">Customer ID</th>
                                            <th width="20%">Customer Name</th>
                                            <th width="15%">
                                                <i class="fa fa-cog"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($available_bookings_list as $bookings)
                                        <tr>
                                            <td class="booking_table_hide_col">{{$bookings->book_id}}</td>
                                            <td>{{$bookings->booking_id}}</td>
                                            <td>{{$bookings->ac_type_name}}</td>
                                            <td>{{$bookings->service_name}}</td>
                                            <td>{{$bookings->booking_created_at}}</td>
                                            <td class="booking_table_hide_col">{{$bookings->customer_id}}</td>
                                            <td>{{$bookings->customer_name}}</td>
                                            <td class="pr-5 pl-5">
                                                <button data-booking_id="{{$bookings->booking_id}}" class="edit_booking_modal_button btn btn-sm btn-primary-gmis">
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

            <div class="row mt-4">
                <div class="col-md-12 pl-5 pr-5">
                    <div class="card card-outline card-gmis">
                        <div class="card-header">                            
                            <h3 class="card-title text-bold">Current Job Orders</h3>
                        </div>
                        <div class="card-body">   

                            <div class="datatable_scroll" style="position: relative; overflow: auto; width: 100%;">
                                <table id="joborder_table" class="table table-bordered table-hover">
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
                                            <td class="joborder_table_hide_col">{{$jo->jo_id}}</td>
                                            <td>{{$jo->job_order_id}}</td>
                                            <td id="view_booking_modal_button" style="cursor:pointer;color:#007bff;">{{$jo->booking_id}}</td>
                                            <td>{{$jo->jo_schedule_date}}</td>
                                            <td>{{$jo->jo_issued_date}}</td>
                                            <td class="joborder_table_hide_col">{{$jo->technician_id}}</td>
                                            <td>{{$jo->technician_name}}</td>
                                            <td>
                                                {{-- <span class="badge badge-gmis {{($jo->jo_status == 'Accepted') ? 'bg-success' : 'bg-danger'}}">{{$jo->jo_status}}</span> --}}                                                
                                                @if($jo->jo_status == 'Accepted')
                                                    <span class="badge badge-gmis bg-success">{{$jo->jo_status}}<span>
                                                @elseif($jo->jo_status == 'In Progress')
                                                    <span class="badge badge-gmis bg-primary">{{$jo->jo_status}}</span>
                                                @elseif($jo->jo_status == 'In Queue')
                                                    <span class="badge badge-gmis bg-info">{{$jo->jo_status}}</span>
                                                @elseif($jo->jo_status == 'Postponed')
                                                    <span class="badge badge-gmis bg-warning">{{$jo->jo_status}}</span>
                                                @elseif($jo->jo_status == 'Cancelled')
                                                    <span class="badge badge-gmis bg-danger">{{$jo->jo_status}}</span>
                                                @endif
                                            </td>
                                            <td class="pr-5 pl-5">
                                                <div class="row">
                                                    @if($jo->technician_id != '')
                                                        <button data-jo_id="{{$jo->job_order_id}}" class="view_jo_modal_button btn btn-sm btn-warning" style="margin-right:2px;">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    @endif
                                                    <button data-jo_id="{{$jo->job_order_id}}" class="edit_jo_modal_button btn btn-sm btn-primary-gmis">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    
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

        </div>
    </section>

    <div class="modal fade" id="view_booking_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">View Booking Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                    <div class="modal-body">
                        
                        <div class="container-fluid">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="booking_id" class="col-form-label text-sm">Booking ID</label>
                                    <input type="text" class="form-control form-control-sm" id="booking_id" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="booking_date" class="col-form-label text-sm">Booking Date</label>
                                    <input type="text" class="form-control form-control-sm" id="booking_date" readonly>
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
                                    <label for="customer_name_wtih_id" class="col-form-label text-sm">Customer Name (ID)</label>
                                    <input type="text" class="form-control form-control-sm" id="customer_name_wtih_id" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="booking_date" class="col-form-label text-sm">Customer Address</label>
                                    <textarea type="text" class="form-control form-control-sm" id="customer_address" rows="3" readonly style="resize:none;"></textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="customer_contact_number" class="col-form-label text-sm">Customer Contact #</label>
                                    <input type="text" class="form-control form-control-sm" id="customer_contact_number" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_email_address" class="col-form-label text-sm">Customer Email Address</label>
                                    <input type="text" class="form-control form-control-sm" id="customer_email_address" readonly>
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
                                    <label for="customer_device_brand_name" class="col-form-label text-sm">Device Brand</label>
                                    <input type="text" class="form-control form-control-sm" id="customer_device_brand_name" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_device_serial_number" class="col-form-label text-sm">Device Serial #</label>
                                    <input type="text" class="form-control form-control-sm" id="customer_device_serial_number" readonly>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="customer_device_ac_type" class="col-form-label text-sm">AC Type</label>
                                    <input type="text" class="form-control form-control-sm" id="customer_device_ac_type" readonly>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="text-sm">Booking Schedule</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="col-form-label text-sm">Service Type</label>
                                </div>
                                <div class="col-md-10">
                                    <p class="col-form-label" id="booking_service_name"></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="datatable_scroll" style="position: relative; overflow: auto; width: 100%;">
                                        <table id="booking_schedule_table" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="25%">Schedule Date</th>
                                                    <th width="25%">Start Time</th>
                                                    <th width="25%">End Time</th>
                                                    <th width="25%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
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

    <div class="modal fade" id="edit_booking_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Get Job Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="create_job_order_form" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        
                        <div class="container-fluid">

                            <div class="container-fluid">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="edit_booking_id" class="col-form-label text-sm">Booking ID</label>
                                        <input type="text" class="form-control form-control-sm" id="edit_booking_id" name="edit_booking_id" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="edit_booking_date" class="col-form-label text-sm">Booking Date</label>
                                        <input type="text" class="form-control form-control-sm" id="edit_booking_date" readonly>
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
                                        <label for="edit_customer_name_wtih_id" class="col-form-label text-sm">Customer Name (ID)</label>
                                        <input type="text" class="form-control form-control-sm" id="edit_customer_name_wtih_id" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="edit_booking_date" class="col-form-label text-sm">Customer Address</label>
                                        <textarea type="text" class="form-control form-control-sm" id="edit_customer_address" rows="3" readonly style="resize:none;"></textarea>
                                    </div>
                                </div>
                                
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="edit_customer_contact_number" class="col-form-label text-sm">Customer Contact #</label>
                                        <input type="text" class="form-control form-control-sm" id="edit_customer_contact_number" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="edit_customer_email_address" class="col-form-label text-sm">Customer Email Address</label>
                                        <input type="text" class="form-control form-control-sm" id="edit_customer_email_address" readonly>
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
                                        <label for="edit_customer_device_brand_name" class="col-form-label text-sm">Device Brand</label>
                                        <input type="text" class="form-control form-control-sm" id="edit_customer_device_brand_name" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="edit_customer_device_serial_number" class="col-form-label text-sm">Device Serial #</label>
                                        <input type="text" class="form-control form-control-sm" id="edit_customer_device_serial_number" readonly>
                                    </div>
                                </div>
                                
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="edit_customer_device_ac_type" class="col-form-label text-sm">AC Type</label>
                                        <input type="text" class="form-control form-control-sm" id="edit_customer_device_ac_type" readonly>
                                    </div>
                                </div>
    
                                <hr>
    
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="text-sm">Get Job Order</h4>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="col-form-label text-sm">Service Type</label>
                                    </div>
                                    <div class="col-md-10">
                                        <p class="col-form-label" id="edit_booking_service_name"></p>
                                    </div>
                                </div>
    
                                <div class="row mb-4">
                                    <div class="col-sm-6">
                                        
                                        <input type="text" class="form-control form-control-sm" id="edit_job_order_id" name="edit_job_order_id" hidden>
                                        <div class="form-group text-sm">
                                            <label for="edit_select_customer_booking_schedules" class="col-form-label text-sm">Booking Schedules</label>
                                            <select class="form-control form-control-sm select2 text-sm" id="edit_select_customer_booking_schedules" name="edit_select_customer_booking_schedules" style="width: 100%;">
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        
                                        <div class="form-group text-sm">
                                            <label for="edit_select_assign_technician" class="col-form-label text-sm">Assign to technician</label>
                                            <select class="form-control form-control-sm select2 text-sm" id="edit_select_assign_technician" name="edit_select_assign_technician" style="width: 100%;">
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_create_job_order" class="btn btn-primary-gmis float-right">Create Job Order</button>
                    </div>
                </form>                
            </div>
        </div>
    </div>

    <div class="modal fade" id="view_jo_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl">
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

    <div class="modal fade" id="edit_jo_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Job Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="edit_assign_jo_form" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="text-sm">Edit Job Order</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="edit_assign_selected_job_order_id" class="col-form-label text-sm">Job Order ID</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_selected_job_order_id" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_assign_jo_issued_date" class="col-form-label text-sm">JO Issue Date</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_jo_issued_date" readonly>
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
                                    <label for="edit_assign_jo_status" class="col-form-label text-sm">Status</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_jo_status" readonly>
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
                                    <label for="edit_assign_jo_service_name" class="col-form-label text-sm">Service Name</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_jo_service_name" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_assign_jo_schedule_date" class="col-form-label text-sm">JO Schedule Date</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_jo_schedule_date" readonly>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="edit_assign_jo_schedule_start_time" class="col-form-label text-sm">JO Schedule Start Time</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_jo_schedule_start_time" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_assign_jo_schedule_end_time" class="col-form-label text-sm">JO Schedule Start Time</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_jo_schedule_end_time" readonly>
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
                                    <label for="edit_assign_jo_customer_device_brand_name" class="col-form-label text-sm">Device Brand</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_jo_customer_device_brand_name" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_assign_jo_customer_device_serial_number" class="col-form-label text-sm">Device Serial #</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_jo_customer_device_serial_number" readonly>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="edit_assign_jo_customer_device_ac_type" class="col-form-label text-sm">AC Type</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_jo_customer_device_ac_type" readonly>
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
                                    <label for="edit_assign_jo_customer_name_wtih_id" class="col-form-label text-sm">Customer Name (ID)</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_jo_customer_name_wtih_id" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_assign_jo_customer_address" class="col-form-label text-sm">Customer Address</label>
                                    <textarea type="text" class="form-control form-control-sm" id="edit_assign_jo_customer_address" rows="3" readonly style="resize:none;"></textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="edit_assign_jo_customer_contact_number" class="col-form-label text-sm">Customer Contact #</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_jo_customer_contact_number" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_assign_jo_customer_email_address" class="col-form-label text-sm">Customer Email Address</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_jo_customer_email_address" readonly>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="col-form-label text-sm">Service Type</label>
                                </div>
                                <div class="col-md-10">
                                    <p class="col-form-label" id="edit_assign_booking_service_name"></p>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    
                                    <input type="text" class="form-control form-control-sm" id="edit_assign_job_order_id" name="edit_assign_job_order_id" hidden>
                                    <div class="form-group text-sm">
                                        <label for="edit_assign_select_customer_booking_schedules" class="col-form-label text-sm">Booking Schedules</label>
                                        <select class="form-control form-control-sm select2 text-sm" id="edit_assign_select_customer_booking_schedules" name="edit_assign_select_customer_booking_schedules" style="width: 100%;">
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-6">
                                    
                                    <div class="form-group text-sm">
                                        <label for="edit_assign_select_assign_technician" class="col-form-label text-sm">Assign to technician</label>
                                        <select class="form-control form-control-sm select2 text-sm" id="edit_assign_select_assign_technician" name="edit_assign_select_assign_technician" style="width: 100%;">
                                        </select>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="edit_job_order" class="btn btn-primary-gmis">Edit Job Order</button>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
            
@endsection

@section('third_party_scripts')
    <script type="module">
        function displayLoader(bol){
            document.getElementById("page-loader-wrapper").style.display = (bol) ? "block" : "none";
        };

        $('#booking_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "ordering": false
        });
        
        $('#booking_schedule_table').DataTable({
            "paging": false,
            "lengthChange": false,
            "info": false,
            "searching": false,
            "autoWidth": false,
            "responsive": true,
            "ordering": false
        });

        $('#joborder_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "ordering": false
        });

        $('#edit_select_customer_booking_schedules').select2();
        $('#edit_assign_select_customer_booking_schedules').select2();
        $('#edit_select_assign_technician').select2();
        $('#edit_assign_select_assign_technician').select2();

        // BOOKING        
        $('#booking_table').on('click', '.edit_booking_modal_button', function() {
            var edit_book_sched_id = $(this).closest('tr').find('td:eq(0)').text();
            var edit_booking_id = $(this).closest('tr').find('td:eq(1)').text();

            $.ajax({
                type: 'GET',
                url: 'get_booking_info_for_job_order/'+edit_book_sched_id+'/'+edit_booking_id,
                beforeSend: function(){
                    /* Show image container */
                    displayLoader(true);
                },
                success:function(data) {
                    console.log(data);

                    $('#edit_booking_id').val(data['booking_information'][0]['booking_id']);
                    $('#edit_job_order_id').val(data['booking_information'][0]['job_order_id']);
                    $('#edit_booking_date').val(data['booking_information'][0]['booking_date']);
                    $('#edit_customer_name_wtih_id').val(data['booking_information'][0]['customer_name'] +' (' + data['booking_information'][0]['customer_id'] + ')');
                    $('#edit_customer_address').val(data['booking_information'][0]['complete_customer_address']);
                    $('#edit_customer_contact_number').val(data['booking_information'][0]['customer_contact_number']);
                    $('#edit_customer_email_address').val(data['booking_information'][0]['customer_email_address']);
                    $('#edit_customer_device_serial_number').val(data['booking_information'][0]['customer_device_serial_number']);
                    $('#edit_customer_device_brand_name').val(data['booking_information'][0]['customer_device_brand_name']);
                    $('#edit_customer_device_ac_type').val(data['booking_information'][0]['ac_type_name']);

                    $('#edit_booking_service_name').text(data['booking_schedule'][0]['service_name']);
                    
                    // ADD SCHEDULES TO SELECT
                    $('#edit_select_customer_booking_schedules option').remove();
                    $('#edit_select_customer_booking_schedules').append('<option value="">Select Schedule</option>');
                    $.each(data['booking_schedule'], function(i,schedule){
                        $('#edit_select_customer_booking_schedules').append('<option data-book_sched_id="'+schedule.book_sched_id+'" value="'+schedule.book_sched_id+'">'+schedule.schedule_with_time+'</option>');
                    });

                    // ADD TECHNICIAN TO SELECT
                    $('#edit_select_assign_technician option').remove();
                    $('#edit_select_assign_technician').append('<option value="">Select Technician</option>');
                    $.each(data['technician_list'], function(i,technician){
                        $('#edit_select_assign_technician').append('<option value="'+technician.technician_id+'">'+technician.technician_name+'</option>');
                    });
                    
                    $('#edit_booking_modal').modal('show');
                },
                complete:function(data){
                    /* Hide image container */
                    displayLoader(false);
                }
            });         
        });

        // CREATE JOB ORDER FORM
        $("#create_job_order_form").validate({
            rules: {
                edit_booking_id: {
                    required: true,
                },
                edit_job_order_id: {
                    required: true,
                },
                edit_select_customer_booking_schedules: {
                    required: true,
                },
                edit_select_assign_technician: {
                    required: true
                }
            },
            messages: {
                edit_booking_id: {
                    required: "This field is required.",
                },
                edit_job_order_id: {
                    required: "This field is required.",
                },
                edit_select_customer_booking_schedules: {
                    required: "This field is required.",
                },
                edit_select_assign_technician: {
                    required: "This field is required."
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form, e) {
                e.preventDefault();
                var create_joborder_form = $(form).serialize();

                swal.fire({
                    title: "Continue grabbing this job order?",
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, continue!",
                    confirmButtonColor: '#007bff',
                    cancelButtonText: "No, wait go back!",
                    reverseButtons: !0
                }).then(function (e) {
                    if(e.value === true){
                        create_job_order(create_joborder_form);
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        });

        function create_job_order(create_joborder_form){
            console.log(create_job_order);
            $.ajax({
                url: 'add_joborder',
                type: "POST",
                data: create_joborder_form,
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
        
        // VIEW BOOKING
        $('#joborder_table').on('click', '#view_booking_modal_button', function() {
            var booking_id = $(this).closest('tr').find('td:eq(2)').text();

            console.log(booking_id)

            $.ajax({
                type: 'GET',
                url: 'get_booking_info/'+booking_id,
                beforeSend: function(){
                    /* Show image container */
                    displayLoader(true);
                },
                success:function(data) {
                    console.log(data);

                    $('#booking_id').val(data['detailed_booking_information'][0]['booking_id']);
                    $('#booking_date').val(data['detailed_booking_information'][0]['booking_created_at']);
                    $('#customer_name_wtih_id').val(data['detailed_booking_information'][0]['customer_name'] +' (' + data['detailed_booking_information'][0]['customer_id'] + ')');
                    $('#customer_address').val(data['detailed_booking_information'][0]['complete_customer_address']);
                    $('#customer_contact_number').val(data['detailed_booking_information'][0]['customer_contact_number']);
                    $('#customer_email_address').val(data['detailed_booking_information'][0]['customer_email_address']);
                    $('#customer_device_serial_number').val(data['detailed_booking_information'][0]['customer_device_serial_number']);
                    $('#customer_device_brand_name').val(data['detailed_booking_information'][0]['customer_device_brand_name']);
                    $('#customer_device_ac_type').val(data['detailed_booking_information'][0]['ac_type_name']);

                    $('#booking_service_name').text(data['detailed_booking_schedule'][0]['service_name']);
                    
                    $('#booking_schedule_table').DataTable().clear().draw();
                    $.each(data['detailed_booking_schedule'], function (i, value) {
                        $('#booking_schedule_table').DataTable().row.add([
                            data["detailed_booking_schedule"][i].schedule_date,
                            data["detailed_booking_schedule"][i].start_time,
                            data["detailed_booking_schedule"][i].end_time,
                            (data["detailed_booking_schedule"][i].active == 0 ? "Inactive" : "Active" )
                        ]).draw();
                    });

                    $('#view_booking_modal').modal('show');
                },
                complete:function(data){
                    /* Hide image container */
                    displayLoader(false);
                }
            });
                
        });
        

        // JOB ORDER
        $('#joborder_table').on('click', '.edit_jo_modal_button', function() {
            var edit_jo_id = $(this).closest('tr').find('td:eq(0)').text();
            var edit_joborder_id = $(this).closest('tr').find('td:eq(1)').text();
            var edit_technician_id = $(this).closest('tr').find('td:eq(5)').text();
            console.log(edit_joborder_id);

            $.ajax({
                type: 'GET',
                url: 'get_joborder_info_for_edit_assign/'+edit_jo_id+'/'+edit_joborder_id,
                beforeSend: function(){
                    /* Show image container */
                    displayLoader(true);
                },
                success:function(data) {
                    console.log(data);

                    $('#edit_assign_selected_job_order_id').val(data['edit_jo_joborder_information'][0]['job_order_id']);
                    $('#edit_assign_job_order_id').val(data['edit_jo_joborder_information'][0]['job_order_id']);
                    $('#edit_assign_jo_issued_date').val(data['edit_jo_joborder_information'][0]['jo_issued_date']);
                    $('#edit_assign_jo_status').val(data['edit_jo_joborder_information'][0]['jo_status']);
                    
                    $('#edit_assign_jo_service_name').val(data['edit_jo_booking_schedule_list'][0]['service_name']);
                    $('#edit_assign_jo_schedule_date').val(data['edit_jo_joborder_information'][0]['jo_schedule_date']);
                    $('#edit_assign_jo_schedule_start_time').val(data['edit_jo_booking_schedule_list'][0]['start_time']);
                    $('#edit_assign_jo_schedule_end_time').val(data['edit_jo_booking_schedule_list'][0]['end_time']);
                    
                    $('#edit_assign_jo_customer_device_brand_name').val(data['edit_jo_joborder_information'][0]['customer_device_serial_number']);
                    $('#edit_assign_jo_customer_device_serial_number').val(data['edit_jo_joborder_information'][0]['customer_device_brand_name']);
                    $('#edit_assign_jo_customer_device_ac_type').val(data['edit_jo_joborder_information'][0]['ac_type_name']);

                    $('#edit_assign_jo_customer_name_wtih_id').val(data['edit_jo_joborder_information'][0]['customer_name'] +' (' + data['edit_jo_joborder_information'][0]['customer_id'] + ')');
                    $('#edit_assign_jo_customer_address').val(data['edit_jo_joborder_information'][0]['complete_customer_address']);
                    $('#edit_assign_jo_customer_contact_number').val(data['edit_jo_joborder_information'][0]['customer_contact_number']);
                    $('#edit_assign_jo_customer_email_address').val(data['edit_jo_joborder_information'][0]['customer_email_address']);
                    
                    $('#edit_assign_booking_service_name').text(data['edit_jo_booking_schedule_list'][0]['service_name']);
                    
                    // ADD SCHEDULES TO SELECT
                    var selected_sched = '';
                    $('#edit_assign_select_customer_booking_schedules option').remove();
                    $('#edit_assign_select_customer_booking_schedules').append('<option value="">Select Schedule</option>');
                    $.each(data['edit_jo_booking_schedule_list'], function(i,schedule){
                        $('#edit_assign_select_customer_booking_schedules').append('<option data-booking_sched_id="'+schedule.booking_schedule_id+'" value="'+schedule.book_sched_id+'">'+schedule.schedule_with_time+'</option>');
        
                        if(schedule.active == 1){
                            selected_sched = schedule.book_sched_id;
                        }
                    });
                    
                    console.log(selected_sched);     

                    if(selected_sched != null || selected_sched == ''){
                        $('#edit_assign_select_customer_booking_schedules').val(selected_sched);
                        $('#edit_assign_select_customer_booking_schedules').trigger('change');
                    }

                    // ADD TECHNICIAN TO SELECT
                    $('#edit_assign_select_assign_technician option').remove();
                    $('#edit_assign_select_assign_technician').append('<option value="">Select Technician</option>');
                    $.each(data['edit_jo_technician_list'], function(i,technician){
                        $('#edit_assign_select_assign_technician').append('<option value="'+technician.technician_id+'">'+technician.technician_name+'</option>');
                    });      
                    
                    console.log(edit_technician_id);              

                    if(edit_technician_id == null || edit_technician_id == ''){
                    }else{                        
                        $('#edit_assign_select_assign_technician').val(edit_technician_id);
                        $('#edit_assign_select_assign_technician').trigger('change');
                    }

                    $('#edit_jo_modal').modal('show');
                },
                complete:function(data){
                    /* Hide image container */
                    displayLoader(false);
                }
            });

        });

        // EDIT JOB ORDER FORM
        $("#edit_assign_jo_form").validate({
            rules: {
                edit_assign_job_order_id: {
                    required: true,
                },
                edit_assign_select_customer_booking_schedules: {
                    required: true,
                },
                edit_assign_select_assign_technician: {
                    required: true
                }
            },
            messages: {
                edit_assign_job_order_id: {
                    required: "This field is required.",
                },
                edit_assign_select_customer_booking_schedules: {
                    required: "This field is required.",
                },
                edit_assign_select_assign_technician: {
                    required: "This field is required."
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form, e) {
                e.preventDefault();
                var edit_joborder_form = $(form).serialize();

                swal.fire({
                    title: "Continue editing this job order?",
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, continue!",
                    confirmButtonColor: '#007bff',
                    cancelButtonText: "No, wait go back!",
                    reverseButtons: !0
                }).then(function (e) {
                    if(e.value === true){
                        edit_job_order(edit_joborder_form);
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        });

        function edit_job_order(edit_joborder_form){
            console.log(edit_joborder_form);
            $.ajax({
                url: 'edit_joborder',
                type: "POST",
                data: edit_joborder_form,
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

        // VIEW JOB ORDER

        $('#joborder_table').on('click', '.view_jo_modal_button', function() {
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

    </script>
@endsection