@extends('layouts.app')

@section('third_party_stylesheets')
    <style>
        table#technicians_table thead th, table#technicians_table tbody td{
            text-align:center;
            vertical-align: middle;
        }
               
        .pic-overlay{
            opacity: 0.7;
            position: relative;
            text-align: center;
            /* display: flex; */
            align-items: center;
            justify-content: center;
            bottom: 29px;
            left: 45px;
        }
        .pic-overlay .fa-camera{
            color: #1586FF;
            font-weight: bold;
        }
        .upload-button{
            font-size:1.5em;
        }

        @media (max-width:796px){
            table#technicians_table{
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
                            <h3 class="card-title text-bold">Technicians</h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#card-view" data-toggle="tab">Card View</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#table-view" data-toggle="tab">Table View</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">    

                            <div class="tab-content">
                                <div class="active tab-pane" id="card-view">
                                    <div class="row">
                                        
                                        @foreach($technician_list as $technicians)
                                            <div class="col-lg-4 col-md-6 d-flex align-items-stretch flex-column">
                                                <div class="card bg-light d-flex flex-fill">
                                                    <div class="card-header border-bottom-0">
                                                        <h2 class="lead"><b>{{$technicians->technician_name}}</b></h2>
                                                    </div>
                                                    <div class="card-body pt-0">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                                    <li class="small">
                                                                        <span class="fa-li"><i class="fas fa-lg fa-building"></i></span>Address: {{$technicians->complete_technician_address}}
                                                                    </li>
                                                                    <li class="small mt-2">
                                                                        <span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{$technicians->technician_contact_number}}
                                                                    </li>
                                                                    <li class="small mt-2">
                                                                        <span class="fa-li"><i class="fas fa-lg fa-at"></i></span> Email: {{$technicians->technician_email_address}}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-5 text-center">
                                                                <img src="{{($technicians->technician_profile_image == '') ? asset('/img/img_avatar.png') : env('DO_SPACES_CDN_ENDPOINT')."/cleaningapp-profile-images/".$technicians->technician_profile_image}}" alt="Technician profile picture" class="img-circle img-fluid gmis-profile-img">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="row">
                                                            <div class="col-6">                                                        
                                                                <span class="badge badge-gmis {{($technicians->technician_partner_status == 'Active') ? 'bg-success' : 'bg-danger'}}">{{$technicians->technician_partner_status}}</span>
                                                            </div>
                                                            <div class="col-6 float-right" style="text-align:right;">
                                                                {{-- <a href="#" class="btn btn-sm bg-danger">
                                                                    <i class="fas fa-times"></i>
                                                                </a> --}}
                                                                <button data-technician_id="{{$technicians->technician_id}}" class="edit_technician_modal_button btn btn-sm btn-primary-gmis">
                                                                    <i class="fas fa-user-cog"></i>
                                                                </button>
                                                            </div>                                                    
                                                        </div>   
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                    </div>  
                                </div>
                                <div class="tab-pane" id="table-view">
                                    <div class="datatable_scroll" style="position: relative; overflow: auto; width: 100%;">
                                        <table id="technicians_table" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="15%"></th>
                                                    <th width="20%">Name</th>
                                                    <th width="30%">Address</th>
                                                    <th width="15%">Phone Number | Email Address</th>
                                                    <th width="10%">Status</th>
                                                    <th width="10%">
                                                        <i class="fa fa-cog"></i>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($technician_list as $technicians)
                                                <tr>                                             
                                                    <td><img class="gmis-profile-img img-fluid img-circle" src="{{($technicians->technician_profile_image == '') ? asset('/img/img_avatar.png') : env('DO_SPACES_CDN_ENDPOINT')."/cleaningapp-profile-images/".$technicians->technician_profile_image}}" alt="Technician profile picture"></td>
                                                    <td>{{$technicians->technician_name}}</td>
                                                    <td>{{$technicians->complete_technician_address}}</td>
                                                    <td>{{$technicians->technician_contact_number}} | {{$technicians->technician_email_address}}</td>
                                                    <td>
                                                        <span class="badge badge-gmis {{($technicians->technician_partner_status == 'Active') ? 'bg-success' : 'bg-danger'}}">{{$technicians->technician_partner_status}}</span>
                                                    </td>
                                                    <td class="pr-5 pl-5">
                                                        <button data-technician_id="{{$technicians->technician_id}}" class="edit_technician_modal_button btn btn-sm btn-primary-gmis">
                                                            <i class="fas fa-user-cog"></i>
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
                        <div class="card-footer clearfix text-muted">
                            <div class="row">
                                <div class="col-sm-6">
                                    <button class="btn btn-primary-gmis" data-toggle="modal" data-target="#add_technician_modal"><i class="fas fa-user-plus"></i> Add Technician</button>
                                </div>
                                <div class="col-sm-6" style="text-align:end;padding-top:6px;">
                                    Number of Technicians: <span class="text-bold">{{$technician_count[0]->number_of_technicians}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div class="modal fade" id="modify_technician_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Technician Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                    <div class="modal-body">
                        
                            <div class="container-fluid">
                                <div class="row">

                                    <div class="col-md-3">
                                        {{-- <div class="card card-gmis card-outline">
                                            <div class="card-body box-profile"> --}}
                                                <div class="text-center">
                                                    <img class="gmis-technician-modify-img img-fluid img-circle" id="modify_technician_profile_image" alt="Technician profile picture">
                                                    <div class="pic-overlay">
                                                        <i class="fa fa-camera upload-button" title="Update profile" style="cursor:pointer;"></i>
                                                        <input class="file-upload" name="file-upload" type="file" accept="image/*" style="display: none;">
                                                    </div>
                                                    <h3 class="technician-modify-username text-center">--</h3>
                                                    <p class="technician-modify-id text-muted text-center">--</p>
                                                </div>
                                            {{-- </div>
                                        </div> --}}
                                    </div>
                                    
                                    <div class="col-md-9">
                                        <form id="modify_technician_info_form" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="form-group text-sm">
                                                        <input type="text" class="form-control form-control-sm" id="modify_technician_id" name="modify_technician_id" hidden>
                                                        <label for="modify_technician_first_name" class="col-form-label">First Name</label>
                                                        <input type="text" class="form-control form-control-sm" id="modify_technician_first_name" name="modify_technician_first_name" placeholder="Enter First Name">
                                                    </div>
                                                </div>    
                                                <div class="col-sm-3">
                                                    <div class="form-group text-sm">
                                                        <label for="modify_technician_middle_name" class="col-form-label">Middle Name</label>
                                                        <input type="text" class="form-control form-control-sm" id="modify_technician_middle_name" name="modify_technician_middle_name" placeholder="Enter Middle Name">
                                                    </div>
                                                </div>   
                                                <div class="col-sm-4">
                                                    <div class="form-group text-sm">
                                                        <label for="modify_technician_last_name" class="col-form-label">Last Name</label>
                                                        <input type="text" class="form-control form-control-sm" id="modify_technician_last_name" name="modify_technician_last_name" placeholder="Enter Last Name">
                                                    </div>
                                                </div>     
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group text-sm">
                                                        <label for="modify_technician_birthdate" class="col-form-label">Birthdate</label>
                                                        <input type="text" class="form-control form-control-sm datetimepicker-input" id="modify_technician_birthdate" name="modify_technician_birthdate"  data-toggle="datetimepicker" data-target="#modify_technician_birthdate">
                                                    </div>
                                                </div>     
                                                <div class="col-sm-4">
                                                    <div class="form-group text-sm">
                                                        <label for="modify_technician_contact_number" class="col-form-label">Phone Number</label>
                                                        <input type="text" class="form-control form-control-sm" id="modify_technician_contact_number" name="modify_technician_contact_number" placeholder="Enter Phone Number">
                                                    </div>
                                                </div>  
                                                <div class="col-sm-4">
                                                    <div class="form-group text-sm">
                                                        <label for="modify_technician_email_address" class="col-form-label">Email Address</label>
                                                        <input type="text" class="form-control form-control-sm" id="modify_technician_email_address" name="modify_technician_email_address" placeholder="Enter Email Address">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group text-sm">
                                                        <label for="partner_id" class="col-form-label">Address</label>
                                                        <textarea class="form-control form-control-sm" rows="2" id="modify_technician_address" name="modify_technician_address" placeholder="Enter Address" style="resize: none;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group text-sm">
                                                        <label for="modify_technician_select_province" class="col-form-label">Province</label>
                                                        <select class="form-control form-control-sm select2" id="modify_technician_select_province" name="modify_technician_select_province" style="width: 100%;">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">       
                                                <div class="col-sm-5">
                                                    <div class="form-group text-sm">
                                                        <label for="modify_technician_select_city" class="col-form-label">City</label>
                                                        <select class="form-control form-control-sm select2" id="modify_technician_select_city" name="modify_technician_select_city" style="width: 100%;">
                                                        </select>
                                                    </div>
                                                </div>                                             
                                                <div class="col-sm-4">
                                                    <div class="form-group text-sm">
                                                        <label for="modify_technician_select_barangay" class="col-form-label">Barangay</label>
                                                        <select class="form-control select2" id="modify_technician_select_barangay" name="modify_technician_select_barangay" style="width: 100%;">
                                                        </select>
                                                    </div>
                                                </div> 
                                                <div class="col-sm-3">
                                                    <div class="form-group text-sm">
                                                        <label for="modify_technician_zip_code" class="col-form-label">Zip Code</label>
                                                        <input type="text" class="form-control form-control-sm" id="modify_technician_zip_code" name="modify_technician_zip_code" placeholder="Enter Zip Code (Optional)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">     
                                                <div class="col-sm-12">
                                                    <p class="text-muted text-sm" id="address_text"></p>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-3">
                                                <div class="col-sm-12 text-right">
                                                    <button type="submit" id="submit_update_technician" class="btn btn-primary-gmis">Edit Information</button>
                                                </div>
                                            </div>
                                        </form>
                                        {{-- <hr> --}}
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

    <div class="modal fade" id="add_technician_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Technician</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="add_technician_form" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">                                    
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group text-sm">
                                                <label for="add_technician_first_name" class="col-form-label">First Name</label>
                                                <input type="text" class="form-control form-control-sm" id="add_technician_first_name" name="add_technician_first_name" placeholder="Enter First Name">
                                            </div>
                                        </div>    
                                        <div class="col-sm-3">
                                            <div class="form-group text-sm">
                                                <label for="add_technician_middle_name" class="col-form-label">Middle Name</label>
                                                <input type="text" class="form-control form-control-sm" id="add_technician_middle_name" name="add_technician_middle_name" placeholder="Enter Middle Name">
                                            </div>
                                        </div>   
                                        <div class="col-sm-4">
                                            <div class="form-group text-sm">
                                                <label for="add_technician_last_name" class="col-form-label">Last Name</label>
                                                <input type="text" class="form-control form-control-sm" id="add_technician_last_name" name="add_technician_last_name" placeholder="Enter Last Name">
                                            </div>
                                        </div>     
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group text-sm">
                                                <label for="add_technician_birthdate" class="col-form-label">Birthdate</label>
                                                <input type="text" class="form-control form-control-sm datetimepicker-input" id="add_technician_birthdate" name="add_technician_birthdate"  placeholder="Enter Birthdate" data-toggle="datetimepicker" data-target="#add_technician_birthdate">
                                            </div>
                                        </div>     
                                        <div class="col-sm-4">
                                            <div class="form-group text-sm">
                                                <label for="add_technician_contact_number" class="col-form-label">Phone Number</label>
                                                <input type="text" class="form-control form-control-sm" id="add_technician_contact_number" name="add_technician_contact_number" placeholder="Enter Phone Number" maxlength="11">
                                            </div>
                                        </div>  
                                        <div class="col-sm-4">
                                            <div class="form-group text-sm">
                                                <label for="add_technician_email_address" class="col-form-label">Email Address</label>
                                                <input type="text" class="form-control form-control-sm" id="add_technician_email_address" name="add_technician_email_address" placeholder="Enter Enmail Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="add_technician_address" class="col-form-label">Address</label>
                                                <textarea class="form-control form-control-sm" rows="2" id="add_technician_address" name="add_technician_address" placeholder="Enter Address" style="resize: none;"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group text-sm">
                                                <label for="add_technician_select_province" class="col-form-label">Province</label>
                                                <select class="form-control form-control-sm select2" id="add_technician_select_province" name="add_technician_select_province" style="width: 100%;">
                                                    <option value="">--</option>
                                                    @foreach($province_listing as $province_list)
                                                        <option value="{{$province_list->provCode}}" data-city_code="{{$province_list->citymunCode}}">{{$province_list->provDesc}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">       
                                        <div class="col-sm-5">
                                            <div class="form-group text-sm">
                                                <label for="add_technician_select_city" class="col-form-label">City</label>
                                                <select class="form-control form-control-sm select2" id="add_technician_select_city" name="add_technician_select_city" style="width: 100%;" disabled>
                                                </select>
                                            </div>
                                        </div>                                             
                                        <div class="col-sm-4">
                                            <div class="form-group text-sm">
                                                <label for="add_technician_select_barangay" class="col-sm-3 col-form-label">Barangay</label>
                                                <select class="form-control select2" id="add_technician_select_barangay" name="add_technician_select_barangay" style="width: 100%;" disabled>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group text-sm">
                                                <label for="add_technician_zip_code" class="col-form-label">Zip Code</label>
                                                <input type="text" class="form-control form-control-sm" id="add_technician_zip_code" name="add_technician_zip_code" placeholder="Enter Zip Code (Optional)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">     
                                        <div class="col-sm-12">
                                            <p class="text-muted text-sm" id="add_address_text"></p>
                                        </div>
                                    </div>                                        
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_add_technician" class="btn btn-primary-gmis">Add Technician</button>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
            
@endsection

@section('third_party_scripts')
    <script type="module">
        $('#technicians_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "ordering": false
        });
        
        $('#add_technician_select_province').select2();
        $('#add_technician_select_city').select2();
        $('#add_technician_select_barangay').select2();
        
        $('#modify_technician_select_province').select2();
        $('#modify_technician_select_city').select2();
        $('#modify_technician_select_barangay').select2();
        
        $('#modify_technician_birthdate').datetimepicker({
            format: 'YYYY-MM-DD'
        }); 

        $('#add_technician_birthdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $(".edit_technician_modal_button").click(function() {
            console.log($(this).data("technician_id"))
            get_technician_info($(this).data("technician_id"));

        });

        var tech_id = '';
        function get_technician_info(technician_id){
            $.ajax({
                url: 'get_technician_details/' + technician_id,
                type: 'GET',
                success: function( data ){
                    console.log(data);
                    tech_id = data["technician_details"][0]["technician_id"];
                    
                    var asset_url = "{{ asset('/img/') }}";
                    var do_endpoint = "{{env('DO_SPACES_CDN_ENDPOINT')}}"+"/cleaningapp-profile-images/";

                    var technician_profile_image = (data["technician_details"][0]["technician_profile_image"] == null || data["technician_details"][0]["technician_profile_image"] == '') ? "{{asset('/img/img_avatar.png')}}" : do_endpoint + data["technician_details"][0]["technician_profile_image"];

                    $('#modify_technician_profile_image').attr("src", technician_profile_image);
                    $('.technician-modify-username').text(data["technician_details"][0]["technician_name"]);
                    $('.technician-modify-id').text(data["technician_details"][0]["technician_id"]);
                    
                    $('#modify_technician_id').val(data["technician_details"][0]["technician_id"]);
                    $('#modify_technician_first_name').val(data["technician_details"][0]["technician_first_name"]);
                    $('#modify_technician_middle_name').val(data["technician_details"][0]["technician_middle_name"]);
                    $('#modify_technician_last_name').val(data["technician_details"][0]["technician_last_name"]);
                    $('#modify_technician_birthdate').val(data["technician_details"][0]["technician_birthdate"]);
                    $('#modify_technician_contact_number').val(data["technician_details"][0]["technician_contact_number"]);
                    $('#modify_technician_email_address').val(data["technician_details"][0]["technician_email_address"]);

                    $('#modify_technician_address').val(data["technician_details"][0]["technician_address"]);
                    $("#modify_technician_zip_code").val(data["technician_details"][0]["technician_address_zip_code"]);
                    var select_province = '';
                    $.each(data["province_list"], function (key, value) {
                        select_province += '<option value="' + value["provCode"] + '" data-city_code="' + value["citymunCode"] + '">' + value["provDesc"] + '</option>';
                    });
                                        
                    $("#modify_technician_select_province").empty().append(select_province);
                    $("#modify_technician_select_province").prepend('<option value="' + data["technician_details"][0]["provCode"] + '" data-city_code="' + data["technician_details"][0]["citymunCode"] + '" selected>' + data["technician_details"][0]["provDesc"] + '</option>');
                    $("#modify_technician_select_province").prepend('<option value="">-- Please Select --</option>');

                    var select_city = '';
                    $.each(data["city_list"], function (key, value) {
                        select_city += '<option value="' + value["citymunCode"] + '">' + value["citymunDesc"] + '</option>';
                    });
                                        
                    $("#modify_technician_select_city").empty().append(select_city);
                    $("#modify_technician_select_city").prepend('<option value="' + data["technician_details"][0]["citymunCode"] + '" selected>' + data["technician_details"][0]["citymunDesc"] + '</option>');
                    $("#modify_technician_select_city").prepend('<option value="">-- Please Select --</option>');

                    var select_barangay = '';
                    $.each(data["barangay_list"], function (key, value) {
                        select_barangay += '<option value="' + value["id_barangay"] + '">' + value["brgyDesc"] + '</option>';
                    });
                                        
                    $("#modify_technician_select_barangay").empty().append(select_barangay);
                    $("#modify_technician_select_barangay").prepend('<option value="' + data["technician_details"][0]["id_barangay"] + '" selected>' + data["technician_details"][0]["brgyDesc"] + '</option>');
                    $("#modify_technician_select_barangay").prepend('<option value="">-- Please Select --</option>');
                    
                    $('#address_text').text("Complete address: " + data["technician_details"][0]["complete_technician_address"]);
                    $('#modify_technician_modal').modal('show');
                },
                error: function( response ){
                    console.log("Error: " + response);
                }
            });
        }

        $('#modify_technician_select_province').change(function() {
            if($(this).val() != '') {
                $.get('{{url("/get_city")}}/'+$(this).val(), function(data) {
                    $('#modify_technician_select_city').attr('enabled', true);
                    $('#modify_technician_select_city option').remove();
                    $.each(data, function(index,city_list){
                        // if (!$(this).closest('div').find('select[name="product_id[]" option[value="'+subCatObj.id+'"]').length) {
                            $('#modify_technician_select_city').append('<option value="'+city_list.citymunCode+'">'+city_list.citymunDesc+'</option>');
                        // }
                    });
                    $('#modify_technician_select_city').prepend('<option value="">--</option>').change();
                });
            }        
        });

        $('#modify_technician_select_city').change(function() {
            if($(this).val() != '') {
                $.get('{{url("/get_barangay")}}/'+$(this).val(), function(data) {
                    $('#modify_technician_select_barangay').attr('enabled', true);
                    $('#modify_technician_select_barangay option').remove();
                    $('#modify_technician_select_barangay').prepend('<option value="">--</option>');
                    $.each(data, function(index,barangay_list){
                        // if (!$(this).closest('div').find('select[name="product_id[]" option[value="'+subCatObj.id+'"]').length) {
                            $('#modify_technician_select_barangay').append('<option value="'+barangay_list.id_barangay+'">'+barangay_list.brgyDesc+'</option>');
                        // }                    });                    
                    });
                });
                
                $('#address_text').text("Complete address: " + $('#modify_technician_address').val() + ", " + '--' + ", " + $('#modify_technician_select_city option:selected').text() + ", " + $('#modify_technician_select_province option:selected').text());
            }
        });
        
        $('#modify_technician_select_barangay').change(function() {
            $('#address_text').text("Complete address: " + $('#modify_technician_address').val() + ", " + $('#modify_technician_select_barangay option:selected').text() + ", " + $('#modify_technician_select_city option:selected').text() + ", " + $('#modify_technician_select_province option:selected').text());
        });

        
        $('#modify_technician_address').keyup(function() {
            $('#address_text').text("Complete address: " + $('#modify_technician_address').val() + ", " + $('#modify_technician_select_barangay option:selected').text() + ", " + $('#modify_technician_select_city option:selected').text() + ", " + $('#modify_technician_select_province option:selected').text());
        });

        // Change Technician Profile Image

        var readURL = function(input) {
            var input_file = input.files[0];
            var technician_id = tech_id;
            var _token = '{{csrf_token()}}'; 

            console.log(input_file);

            var file_data = new FormData();

            file_data.append('_token', _token);
            file_data.append('technician_id', technician_id);
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
                            url: 'upload_technician_profile_user_image',
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

        // Modify Technician Information FORM
        $("#modify_technician_info_form").validate({
            rules: {
                modify_technician_id: {
                    required: true,
                },
                modify_technician_first_name: {
                    required: true,
                },
                modify_technician_last_name: {
                    required: true,
                },
                modify_technician_birthdate: {
                    required: true,
                },
                modify_technician_address: {
                    required: true,
                },
                modify_technician_select_province: {
                    required: true,
                },
                modify_technician_select_city: {
                    required: true,
                },
                modify_technician_select_barangay: {
                    required: true,
                },
                modify_technician_contact_number: {
                    required: true,
                },
                modify_technician_email_address: {
                    required: true,
                }
            },
            messages: {
                modify_technician_id: {
                    required: "This field is required.",
                },
                modify_technician_first_name: {
                    required: "This field is required.",
                },
                modify_technician_last_name: {
                    required: "This field is required.",
                },
                modify_technician_birthdate: {
                    required: "This field is required.",
                },
                modify_technician_address: {
                    required: "This field is required.",
                },
                modify_technician_select_province: {
                    required: "This field is required.",
                },
                modify_technician_select_city: {
                    required: "This field is required.",
                },
                modify_technician_select_barangay: {
                    required: "This field is required.",
                },
                modify_technician_contact_number: {
                    required: "This field is required.",
                },
                modify_technician_email_address: {
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
                var technicianinformation_form = $(form).serialize();

                swal.fire({
                    title: "Continue updating technician information?",
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, continue!",
                    confirmButtonColor: '#007bff',
                    cancelButtonText: "No, wait go back!",
                    reverseButtons: !0
                }).then(function (e) {
                    if(e.value === true){
                        technician_information_update(technicianinformation_form);
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        });

        function technician_information_update(technicianinformation_form){
            $.ajax({
                url: 'technicianinformation_update',
                type: "POST",
                data: technicianinformation_form,
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

        $('#add_technician_select_province').change(function() {
            if($(this).val() != '') {
                $.get('{{url("/get_city")}}/'+$(this).val(), function(data) {
                    $('#add_technician_select_city').prop('disabled', false);
                    $('#add_technician_select_city option').remove();
                    $.each(data, function(index,city_list){
                        // if (!$(this).closest('div').find('select[name="product_id[]" option[value="'+subCatObj.id+'"]').length) {
                            $('#add_technician_select_city').append('<option value="'+city_list.citymunCode+'">'+city_list.citymunDesc+'</option>');
                        // }
                    });
                    $('#add_technician_select_city').prepend('<option value="">--</option>').change();
                });
            }        
        });

        $('#add_technician_select_city').change(function() {
            if($(this).val() != '') {
                $.get('{{url("/get_barangay")}}/'+$(this).val(), function(data) {
                    $('#add_technician_select_barangay').prop('disabled', false);
                    $('#add_technician_select_barangay option').remove();
                    $('#add_technician_select_barangay').prepend('<option value="">--</option>');
                    $.each(data, function(index,barangay_list){
                        // if (!$(this).closest('div').find('select[name="product_id[]" option[value="'+subCatObj.id+'"]').length) {
                            $('#add_technician_select_barangay').append('<option value="'+barangay_list.id_barangay+'">'+barangay_list.brgyDesc+'</option>');
                        // }                    });                    
                    });
                });
                
                $('#add_address_text').text("Complete address: " + $('#add_technician_address').val() + ", " + '--' + ", " + $('#add_technician_select_city option:selected').text() + ", " + $('#add_technician_select_province option:selected').text() + " " + $('#add_technician_zip_code').val());
            }
        });
        
        $('#add_technician_select_barangay').change(function() {
            $('#add_address_text').text("Complete address: " + $('#add_technician_address').val() + ", " + $('#add_technician_select_barangay option:selected').text() + ", " + $('#add_technician_select_city option:selected').text() + ", " + $('#add_technician_select_province option:selected').text() + " " + $('#add_technician_zip_code').val());
        });

        $('#add_technician_address').keyup(function() {
            $('#add_address_text').text("Complete address: " + $('#add_technician_address').val() + ", " + $('#add_technician_select_barangay option:selected').text() + ", " + $('#add_technician_select_city option:selected').text() + ", " + $('#add_technician_select_province option:selected').text() + " " + $('#add_technician_zip_code').val());
        });

        $('#add_technician_zip_code').keyup(function() {
            $('#add_address_text').text("Complete address: " + $('#add_technician_address').val() + ", " + $('#add_technician_select_barangay option:selected').text() + ", " + $('#add_technician_select_city option:selected').text() + ", " + $('#add_technician_select_province option:selected').text() + " " + $('#add_technician_zip_code').val());
        });


        // Add Technician Information FORM
        $("#add_technician_form").validate({
            rules: {
                add_technician_first_name: {
                    required: true,
                },
                add_technician_last_name: {
                    required: true,
                },
                add_technician_birthdate: {
                    required: true,
                },
                add_technician_address: {
                    required: true,
                },
                add_technician_select_province: {
                    required: true,
                },
                add_technician_select_city: {
                    required: true,
                },
                add_technician_select_barangay: {
                    required: true,
                },
                add_technician_contact_number: {
                    required: true,
                },
                add_technician_email_address: {
                    required: true,
                }
            },
            messages: {
                add_technician_first_name: {
                    required: "This field is required.",
                },
                add_technician_last_name: {
                    required: "This field is required.",
                },
                add_technician_birthdate: {
                    required: "This field is required.",
                },
                add_technician_address: {
                    required: "This field is required.",
                },
                add_technician_select_province: {
                    required: "This field is required.",
                },
                add_technician_select_city: {
                    required: "This field is required.",
                },
                add_technician_select_barangay: {
                    required: "This field is required.",
                },
                add_technician_contact_number: {
                    required: "This field is required.",
                },
                add_technician_email_address: {
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
                var technicianinformation_addform = $(form).serialize();

                swal.fire({
                    title: "Continue adding technician?",
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, continue!",
                    confirmButtonColor: '#007bff',
                    cancelButtonText: "No, wait go back!",
                    reverseButtons: !0
                }).then(function (e) {
                    if(e.value === true){
                        technician_information_add(technicianinformation_addform);
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        });

        function technician_information_add(technicianinformation_addform){
            $.ajax({
                url: 'technicianinformation_add',
                type: "POST",
                data: technicianinformation_addform,
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