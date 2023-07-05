@extends('layouts.app')

@section('third_party_stylesheets')
    <style>
        table#services_table thead th, table#services_table tbody td{
            text-align:center;
            vertical-align: middle;
        }
        
        td.services_table_hide_col{
            display:none;
        }
        
        @media (max-width:796px){
            table#services_table{
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
                            <h3 class="card-title text-bold">Services List</h3>
                            <div class="card-tools">                                
                                <button class="btn btn-primary-gmis" data-toggle="modal" data-target="#add_services_modal"><i class="fas fa-user-plus"></i> Add Services</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datatable_scroll" style="position: relative; overflow: auto; width: 100%;">
                                <table id="services_table" class="table table-bordered table-hover mb-2">
                                    <thead>
                                        <tr>
                                            <th width="0%" style="display:none;"></th>
                                            <th width="25%">Service Name</th>
                                            <th width="40%">Service Description</th>
                                            <th width="15%">Service Partner Price</th>
                                            <th width="10%">Status</th>
                                            <th width="0%" style="display:none;"></th>
                                            <th width="10%">
                                                <i class="fa fa-cog"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($partner_services_list as $partner_services)
                                        <tr>
                                            <td class="services_table_hide_col">{{$partner_services->partner_service_id}}</td>
                                            <td>{{$partner_services->service_name}}</td>
                                            <td>{{$partner_services->service_description}}</td>
                                            <td>{{$partner_services->partner_service_price}}</td>
                                            <td>
                                                <span class="badge badge-gmis {{($partner_services->partner_service_status == 'Active') ? 'bg-success' : 'bg-danger'}}">{{$partner_services->partner_service_status}}</span>
                                            </td>
                                            <td class="services_table_hide_col">{{$partner_services->partner_service_status}}</td>
                                            <td class="pr-5 pl-5">
                                                <button data-technician_id="{{$partner_services->partner_service_id}}" class="edit_services_modal_button btn btn-sm btn-primary-gmis">
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

    <div class="modal fade" id="edit_services_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Services</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="edit_services_form" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">     

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="edit_partner_service_name" class="col-form-label">Service Name</label>
                                                <input type="text" class="form-control form-control-sm" id="edit_partner_service_id" name="edit_partner_service_id" hidden>
                                                <input type="text" class="form-control form-control-sm" id="edit_partner_service_name" name="edit_partner_service_name" placeholder="Enter Service Name" readonly>
                                            </div>
                                        </div>    
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="edit_partner_service_description" class="col-form-label">Service Description</label>
                                                <textarea class="form-control form-control-sm" rows="4" id="edit_partner_service_description" name="edit_partner_service_description" placeholder="Enter Service Description" style="resize: none;" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="edit_partner_service_price" class="col-form-label">Service Price</label>
                                                <input type="text" class="form-control form-control-sm" id="edit_partner_service_price" name="edit_partner_service_price" placeholder="Enter Service Price" maxlength="11">
                                            </div>
                                        </div>  
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="edit_partner_service_status" class="col-form-label">Service Status</label>
                                                <select class="form-control form-control-sm select2" id="edit_partner_service_status" name="edit_partner_service_status" style="width: 100%;">
                                                    <option value="Active">Active<option>
                                                    <option value="Inactive">Inctive<option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                                                         
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_edit_services" class="btn btn-primary-gmis">Edit Services</button>
                    </div>
                
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_services_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Services</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="add_services_form" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="select_service_label" class="col-form-label">Select Service</label>
                                    <select class="form-control form-control-sm select2" id="select_services" name="select_services" style="width: 100%;">
                                        <option value="">-- Please select --</option>
                                        @foreach($services_list as $services)
                                            <option value="{{$services->service_id}}">{{$services->service_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group text-sm">
                                        <label for="add_partner_service_name" class="col-form-label">Service Name</label>
                                        <input type="text" class="form-control form-control-sm" id="add_service_id" name="add_service_id" hidden>
                                        <input type="text" class="form-control form-control-sm" id="add_partner_service_name" name="add_partner_service_name" placeholder="Service Name" readonly>
                                    </div>
                                </div>    
                                <div class="col-sm-6">
                                    <div class="form-group text-sm">
                                        <label for="add_partner_service_description" class="col-form-label">Service Description</label>
                                        <textarea class="form-control form-control-sm" rows="4" id="add_partner_service_description" name="add_partner_service_description" placeholder="Service Description" style="resize: none;" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group text-sm">
                                        <label for="add_partner_service_price" class="col-form-label">Service Price</label>
                                        <input type="text" class="form-control form-control-sm" id="add_partner_service_price" name="add_partner_service_price" placeholder="Enter Service Price" maxlength="11">
                                    </div>
                                </div>  
                                <div class="col-sm-6">
                                    <div class="form-group text-sm">
                                        <label for="add_partner_service_status" class="col-form-label">Service Status</label>
                                        <select class="form-control form-control-sm select2" id="add_partner_service_status" name="add_partner_service_status" style="width: 100%;">
                                            <option value="Active">Active<option>
                                            <option value="Inactive">Inctive<option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_add_services" class="btn btn-primary-gmis">Add Services</button>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
            
@endsection

@section('third_party_scripts')
    <script type="module">
        $('#services_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "ordering": false
        });

        $('#select_services').select2();
        $('#edit_partner_service_status').select2();

        $('#select_services').change(function() {
            var services_id = $('#select_services option:selected').val();

            if(services_id != '') {
                $.ajax({
                    type: 'GET',
                    url: 'get_services_info/'+services_id,
                    success:function(data) {
                        console.log(data);

                        $('#add_service_id').val(data[0]['service_id']);
                        $('#add_partner_service_name').val(data[0]['service_name']);
                        $('#add_partner_service_description').val(data[0]['service_description']);
                    }
                });
            }        
        });

        // Add Services form
        $("#add_services_form").validate({
            rules: {
                add_service_id: {
                    required: true,
                },
                add_partner_service_name: {
                    required: true,
                },
                add_partner_service_description: {
                    required: true,
                },
                add_partner_service_price: {
                    required: true,
                },
                add_partner_service_status: {
                    required: true,
                }
            },
            messages: {
                add_service_id: {
                    required: "This field is required.",
                },
                add_partner_service_name: {
                    required: "This field is required.",
                },
                add_partner_service_description: {
                    required: "This field is required.",
                },
                add_partner_service_price: {
                    required: "This field is required.",
                },
                add_partner_service_status: {
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
                var services_add_form = $(form).serialize();

                swal.fire({
                    title: "Continue adding price for this service?",
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, continue!",
                    confirmButtonColor: '#007bff',
                    cancelButtonText: "No, wait go back!",
                    reverseButtons: !0
                }).then(function (e) {
                    if(e.value === true){
                        services_add(services_add_form);
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        });

        function services_add(services_add_form){
            $.ajax({
                url: 'services_add',
                type: "POST",
                data: services_add_form,
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

        $('#services_table').on('click', '.edit_services_modal_button', function() {
            var edit_partner_service_id = $(this).closest('tr').find('td:eq(0)').text();
            var edit_service_name = $(this).closest('tr').find('td:eq(1)').text();
            var edit_service_description = $(this).closest('tr').find('td:eq(2)').text();
            var edit_service_price = $(this).closest('tr').find('td:eq(3)').text();
            var edit_service_status = $(this).closest('tr').find('td:eq(5)').text();
            
            $('#edit_partner_service_id').val(edit_partner_service_id);
            $('#edit_partner_service_name').val(edit_service_name);
            $('#edit_partner_service_description').val(edit_service_description);
            $('#edit_partner_service_price').val(edit_service_price);
            $('#edit_partner_service_status').val(edit_service_status).change();

            $('#edit_services_modal').modal('show');
        });

        // Edit Services form
        $("#edit_services_form").validate({
            rules: {
                edit_partner_service_id: {
                    required: true,
                },
                edit_partner_service_name: {
                    required: true,
                },
                edit_partner_service_description: {
                    required: true,
                },
                edit_partner_service_price: {
                    required: true,
                },
                edit_partner_service_status: {
                    required: true,
                }
            },
            messages: {
                edit_partner_service_id: {
                    required: "This field is required.",
                },
                edit_partner_service_name: {
                    required: "This field is required.",
                },
                edit_partner_service_description: {
                    required: "This field is required.",
                },
                edit_partner_service_price: {
                    required: "This field is required.",
                },
                edit_partner_service_status: {
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
                var services_update_form = $(form).serialize();

                swal.fire({
                    title: "Continue updating services information?",
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, continue!",
                    confirmButtonColor: '#007bff',
                    cancelButtonText: "No, wait go back!",
                    reverseButtons: !0
                }).then(function (e) {
                    if(e.value === true){
                        services_update(services_update_form);
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        });

        function services_update(services_update_form){
            $.ajax({
                url: 'services_update',
                type: "POST",
                data: services_update_form,
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