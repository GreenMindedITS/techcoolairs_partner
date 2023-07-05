@extends('layouts.app')

@section('third_party_stylesheets')
    <style>
        /* table#address_table thead td, table#address_table tbody td{
            text-align:center;
            vertical-align: middle;
        }

        @media (max-width:796px){
            table#address_table{
                font-size:0.9rem!important;
            }
        } */        
        .pic-overlay{
            opacity: 0.7;
            position: relative;
            text-align: center;
            /* display: flex; */
            align-items: center;
            justify-content: center;
            bottom: 32px;
            left: 44px;
        }
        .pic-overlay .fa-camera{
            color: #1586FF;
            font-weight: bold;
        }
        .upload-button{
            font-size:1.7em;
        }
    </style>
@endsection

@section('content')        
    <section class="content">
        <div class="container-fluid">
            
            <div class="row mt-4">
                <div class="col-md-12 col-sm-12 pl-5 pr-5">
                    <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-gmis">
                            <h3 class="widget-user-username" id="partner_username">{{$partner_info[0]->partner_company_name}}</h3>
                            {{-- <h5 class="widget-user-desc">HVAC contractor in Cagayan de Oro City</h5> --}}
                        </div>
                        <div class="widget-user-image">
                            {{-- <img class="img-circle elevation-2" src="{{(($partner_image[0]->user_profile_image) == '' ? asset('/img/img_avatar.png') : asset('/img/'.$partner_image[0]->user_profile_image))}}" alt="User Avatar"> --}}
                        <img class="img-circle elevation-2" src="{{(($partner_image[0]->user_profile_image == 'img_avatar.png') ? asset('/img/img_avatar.png') : env('DO_SPACES_CDN_ENDPOINT')."/cleaningapp-profile-images/".$partner_image[0]->user_profile_image)}}" alt="User Avatar">
                            <div class="pic-overlay">
                                <i class="fa fa-camera upload-button" title="Update profile" style="cursor:pointer;"></i>
                                <input class="file-upload" name="file-upload" type="file" accept="image/*" style="display: none;">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{$technician_count[0]->number_of_technicians}}</h5>
                                        <span class="description-text">Technicians</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">13,000</h5>
                                        <span class="description-text">Job Orders</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">35</h5>
                                        <span class="description-text">PRODUCTS</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12 pl-5 pr-5">
                    <div class="card card-outline card-gmis">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#information" data-toggle="tab">Partner Information</a></li>
                                <li class="nav-item"><a class="nav-link" href="#addresses" data-toggle="tab">Address</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="information">                                    
                                    <div class="row m-2">
                                        <div class="col-lg-12 col-md-12">
                                            <form id="form_basic_information" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="form-group row">
                                                            <label for="partner_id" class="col-sm-3 col-form-label">Partner ID</label>
                                                            <div class="col-sm-8 col-input">
                                                                <input type="text" class="form-control" value="{{$partner_info[0]->partner_id}}" id="partner_id" name="partner_id" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label for="partner_company_name" class="col-sm-4 col-form-label">Partner Company Name</label>
                                                            <div class="col-sm-8 col-input">
                                                                <input type="text" class="form-control" id="partner_company_name" name="partner_company_name" value="{{$partner_info[0]->partner_company_name}}" placeholder="Partner Company Name">
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                    <div class="col-sm-6">                                      
                                                        <div class="form-group row">
                                                            <label for="partner_person_in_charge" class="col-sm-4 col-form-label">Person in Charge</label>
                                                            <div class="col-sm-8 col-input">
                                                                <input type="text" class="form-control" id="partner_person_in_charge" name="partner_person_in_charge" value="{{$partner_info[0]->partner_person_in_charge}}" placeholder="Enter Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label for="partner_email_address" class="col-sm-4 col-form-label">Partner Email Address</label>
                                                            <div class="col-sm-8 col-input">
                                                                <input type="text" class="form-control" id="partner_email_address" name="partner_email_address" value="{{$partner_info[0]->partner_email_address}}" placeholder="Partner Email Address">
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                    <div class="col-sm-6">                                      
                                                        <div class="form-group row">
                                                            <label for="partner_contact_number" class="col-sm-4 col-form-label">Person Contact Number</label>
                                                            <div class="col-sm-8 col-input">
                                                                <input type="text" class="form-control" id="partner_contact_number" name="partner_contact_number" value="{{$partner_info[0]->partner_contact_number}}" placeholder="Partner Contact Number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <button type="submit" id="submit_partner_information" class="btn btn-primary-gmis">Edit Information</button>
                                                    </div>
                                                </div>
                                                

                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="tab-pane" id="addresses">                                    
                                    <div class="row mt-2 mb-2">
                                        <div class="col-lg-12 col-md-12">
                                            <table id="address_table" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Address</th>
                                                        <th>Barangay, City</th>
                                                        <th>Province</th>
                                                        <th>Map</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="tab-pane" id="addresses">                                    
                                    <div class="row m-2">
                                        <div class="col-lg-12 col-md-12">
                                            <form id="add_address_form" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                @csrf
                                                
                                                <div class="row">
                                                    <div class="col-sm-9">
                                                        <div class="form-group row">
                                                            <label for="partner_id" class="col-sm-2 col-form-label">Address</label>
                                                            <div class="col-sm-9 col-input"> 
                                                                <input type="text" class="form-control" value="{{$partner_info[0]->partner_id}}" id="partner_id" name="partner_id" hidden>
                                                                <textarea class="form-control" rows="2" id="partner_address" name="partner_address" placeholder="Enter address" style="resize: none;">{{$partner_address_info[0]->partner_address}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label for="select_province" class="col-sm-3 col-form-label">Province</label>
                                                            <div class="col-sm-9 col-input">
                                                                <select class="form-control select2" id="select_province" name="select_province" style="width: 100%;">
                                                                    <option value="">-- Please select --</option>
                                                                    <option value="{{$partner_address_info[0]->provCode}}">{{$partner_address_info[0]->provDesc}}</option>
                                                                    @foreach($province_list as $province)
                                                                        <option value="{{$province->provCode}}" data-city_code="{{$province->citymunCode}}">{{$province->provDesc}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label for="select_city" class="col-sm-3 col-form-label">City</label>
                                                            <div class="col-sm-9 col-input">
                                                                <select class="form-control select2" id="select_city" name="select_city" style="width: 100%;" disabled>
                                                                   
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                        
                                                <div class="row">                                                    
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label for="select_barangay" class="col-sm-3 col-form-label">Barangay</label>
                                                            <div class="col-sm-9 col-input">
                                                                <select class="form-control select2" id="select_barangay" name="select_barangay" style="width: 100%;" disabled>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">                                                        
                                                        <div class="form-group row">
                                                            <label for="current_password" class="col-sm-3 col-form-label">Zip Code</label>
                                                            <div class="col-sm-9 col-input">
                                                                <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{$partner_address_info[0]->partner_address_zip_code}}" placeholder="Enter Zip Code (optional)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr class="mb-3">

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h6>Map Information</h6>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">                                                    
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label for="select_barangay" class="col-sm-3 col-form-label">Latitude</label>
                                                            <div class="col-sm-9 col-input">
                                                                <input type="text" class="form-control" id="latitude" name="latitude" value="{{$partner_address_info[0]->partner_address_map_latitude}}" placeholder="Enter Latitude">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">                                                        
                                                        <div class="form-group row">
                                                            <label for="current_password" class="col-sm-3 col-form-label">Longitude</label>
                                                            <div class="col-sm-9 col-input">
                                                                <input type="text" class="form-control" id="longitude" name="longitude" value="{{$partner_address_info[0]->partner_address_map_longitude}}" placeholder="Enter Longitude">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mt-3">
                                                    <div class="col-sm-6">
                                                        <button type="submit" id="submit_partner_address" class="btn btn-primary-gmis">Edit Address</button>
                                                    </div>
                                                </div>
                                            
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="settings">
                                    <div class="row m-2">
                                        <div class="col-lg-8 col-md-12">
                                            <form id="form_changepassword" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="current_password" class="col-sm-4 col-form-label">Current Password</label>
                                                    <div class="col-sm-8 col-input">
                                                        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-4">                                                        
                                                        <label for="new_password" class="col-form-label">New Password</label>
                                                    </div>
                                                    <div class="col-sm-8 col-input">
                                                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="confirm_new_password" class="col-sm-4 col-form-label">Confirm New Password</label>
                                                    <div class="col-sm-8 col-input">
                                                        <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder="Confirm New Password">
                                                    </div>
                                                </div>
                                                <button type="submit" id="submit_change_password" class="btn btn-primary-gmis">Change Password</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    
    {{-- <div class="modal fade" id="add_address_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="add_address_form" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        
                    </div>
                
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_partner_address" class="btn btn-primary-gmis">Add Address</button>
                    </div>
                
                </form>
            </div> --}}
        
        </div>
        
    </div>
@endsection

@section('third_party_scripts')
    <script type="module">        
        var partner_info = {!! json_encode($partner_info) !!};
        var partner_address_info = {!! json_encode($partner_address_info) !!};
        console.log(partner_address_info);
        
        $(document).ready(()=>{

            $('#select_province').val(partner_address_info[0].provCode).change();

            setTimeout(function(){
                $('#select_city').val(partner_address_info[0].citymunCode).change();
            }, 1000);

            setTimeout(function(){
                $('#select_barangay').val(partner_address_info[0].id_barangay).change() 
            }, 2500);
        }); 

        $('#select_province').select2();
        $('#select_city').select2();
        $('#select_barangay').select2();

        $('#address_table').DataTable({
            "lengthChange": false,
            "searching": true,
            "autoWidth": false,
            "responsive": true,
            "ordering": false,
            dom: '<"address_options">frtip',
            "createdRow": function(row, data, dataIndex) {
                $(row.children[0]).addClass("ip_dhnc_hide_col");
            }
        });
        $('div.address_options').html('<button class="address_options btn btn-primary-gmis" data-toggle="modal" data-target="#add_address_modal"><i class="fas fa-plus"></i> Add Address</button>');

        // Profile Image Upload

        var readURL = function(input) {
            var input_file = input.files[0];
            var partner_id = partner_info[0].partner_id;
            var _token = '{{csrf_token()}}'; 

            console.log(input_file);

            var file_data = new FormData();

            file_data.append('_token', _token);
            file_data.append('partner_id', partner_id);
            file_data.append('input_file[]', input_file);

            if (input.files && input.files[0]) {
                swal.fire({
                    title: "Add/change profile image?",
                    icon: 'warning',
                    showCancelButton: !0,
                    confirmButtonText: "Yes, continue!",
                    confirmButtonColor: '#007bff',
                    cancelButtonText: "No, wait go back!",
                    reverseButtons: !0
                }).then(function (e) {
                    if(e.value === true){
                        $.ajax({
                            type: 'POST',
                            url: 'upload_partner_profile_user_image',
                            data: file_data,
                            enctype: 'multipart/form-data',
                            processData: false,
                            contentType: false,
                            success:function(response){
                                if(response.success_flag == 0){
                                    toastr.error(response.message)
                                }else{
                                    toastr.success(response.message);

                                    setTimeout(function(){
                                        window.location.reload();
                                    }, 2000);
                                }
                            }
                        });
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        }

        $(".file-upload").on('change', function(){
            readURL(this);
        });

        $(".upload-button").on('click', function() {
            $(".file-upload").click();
        });

        // Partner Information FORM
        $("#form_basic_information").validate({
            rules: {
                partner_id: {
                    required: true,
                },
                partner_company_name: {
                    required: true,
                },
                partner_person_in_charge: {
                    required: true,
                },
                partner_email_address: {
                    required: true,
                },
                partner_contact_number: {
                    required: true,
                }
            },
            messages: {
                partner_id: {
                    required: "This field is required.",
                },
                partner_company_name: {
                    required: "This field is required.",
                },
                partner_person_in_charge: {
                    required: "This field is required.",
                },
                partner_email_address: {
                    required: "This field is required.",
                },
                partner_contact_number: {
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
                var partnerinformation_form = $(form).serialize();

                swal.fire({
                    title: "Continue updating partner information?",
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, continue!",
                    confirmButtonColor: '#007bff',
                    cancelButtonText: "No, wait go back!",
                    reverseButtons: !0
                }).then(function (e) {
                    if(e.value === true){
                        partner_information_update(partnerinformation_form);
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        });

        function partner_information_update(partnerinformation_form){
            $.ajax({
                url: 'partnerinformation_update',
                type: "POST",
                data: partnerinformation_form,
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

        // Addresses FORM 
        $('#select_province').change(function() {
            if($(this).val() != '') {
                $.get('{{url("/get_city")}}/'+$(this).val(), function(data) {
                    $('#select_city').attr('enabled', true);
                    $('#select_city').removeAttr('disabled');
                    $('#select_city option').remove();
                    $('#select_city').append('<option value="">Select City</option>');
                    $.each(data, function(index,city_list){
                        // if (!$(this).closest('div').find('select[name="product_id[]" option[value="'+subCatObj.id+'"]').length) {
                            $('#select_city').append('<option value="'+city_list.citymunCode+'">'+city_list.citymunDesc+'</option>');
                        // }
                    });
                });
            }        
        });

        $('#select_city').change(function() {
            if($(this).val() != '') {
                $.get('{{url("/get_barangay")}}/'+$(this).val(), function(data) {
                    $('#select_barangay').attr('enabled', true);
                    $('#select_barangay').removeAttr('disabled');
                    $('#select_barangay option').remove();
                    $('#select_barangay').append('<option value="">Select Barangay</option>');
                    $.each(data, function(index,barangay_list){
                        // if (!$(this).closest('div').find('select[name="product_id[]" option[value="'+subCatObj.id+'"]').length) {
                            $('#select_barangay').append('<option value="'+barangay_list.id_barangay+'">'+barangay_list.brgyDesc+'</option>');
                        // }
                    });
                });
            }
        });

        $("#add_address_form").validate({
            rules: {
                partner_id: {
                    required: true,
                },
                partner_address: {
                    required: true,
                },
                select_province: {
                    required: true,
                },
                select_city: {
                    required: true,
                },
                select_barangay: {
                    required: true,
                }
            },
            messages: {
                partner_id: {
                    required: "This field is required.",
                },
                partner_address: {
                    required: "This field is required.",
                },
                select_province: {
                    required: "This field is required.",
                },
                select_city: {
                    required: "This field is required.",
                },
                select_barangay: {
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
                var partneraddress_form = $(form).serialize();

                swal.fire({
                    title: "Continue updating address information?",
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, continue!",
                    confirmButtonColor: '#007bff',
                    cancelButtonText: "No, wait go back!",
                    reverseButtons: !0
                }).then(function (e) {
                    if(e.value === true){
                        partneraddress_update(partneraddress_form);
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        });

        function partneraddress_update(partneraddress_form){
            $.ajax({
                url: 'partneraddress_update',
                type: "POST",
                data: partneraddress_form,
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

        // Change Password FORM
        $("#form_changepassword").validate({
            rules: {
                current_password: {
                    required: true,
                },
                new_password: {
                    required: true,
                },
                confirm_new_password: {
	            	equalTo : "#new_password",
                }
            },
            messages: {
                current_password: {
                    required: "This field is required.",
                },
                new_password: {
                    required: "This field is required.",
                },
                confirm_new_password: {
			   		equalTo : 'Password does not match.',
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
                var changepassword_form = $(form).serialize();

                swal.fire({
                    title: "Continue changing password?",
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, continue!",
                    confirmButtonColor: '#007bff',
                    cancelButtonText: "No, wait go back!",
                    reverseButtons: !0
                }).then(function (e) {
                    if(e.value === true){
                        change_password_update(changepassword_form);
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        });

        function change_password_update(changepassword_form){
            $.ajax({
                url: 'change_password',
                type: "POST",
                data: changepassword_form,
                dataType: "json",
                success: function( response ){
                    if(response.password_mismatch == 1){
                        toastr.error(response.message)
                    }else{
                        toastr.success(response.message)

                        $('#current_password').val('');
                        $('#new_password').val('');
                        $('#confirm_new_password').val('');
                    }
                },
                error: function( response ){
                    console.log("Error: " + response);
                }
            });
        }
        
    </script>
@endsection