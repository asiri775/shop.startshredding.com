@extends('vendor.includes.master-vendor')

@section('content')
    <link href="{{ URL::asset('assets/map/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/map/css/custom.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/map/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/map/css/bootstrap-4-utilities.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <style>
        .w-100 {
            width: 100% !important;
        }
        .order-id{
            max-width: 150px;
            float: left;
            padding-right: 15px;
        }
        .order-id label{
            margin: 8px 0px;
        }
  
    </style>
    <script src="{{ URL::asset('assets/map/js/jquery1.11.3.min.js')}}"></script>
    <script src="{{ URL::asset('assets/map/js/jquery.blockUI.js')}}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="page-title row">
        <h2>{{$client->first_name." ".$client->last_name}}</h2> 
    </div>
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ Session::get('message') }}
        </div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ Session::get('error') }}
        </div>
    @endif

    <div class="container row">
        <div class="row main-row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 left-table">
                <div class="bg-white row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div id="exTab2" class="col-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="{{url('/vendor/customer/'.$client->id)}}" data-toggle="tab">Overview</a></li>
                                <li><a href="{{url('/vendor/customer/'.$client->id.'/templates')}}">Templates</a></li>
                                <li><a href="{{url('/vendor/customer/'.$client->id.'/orders')}}" >Orders</a></li>
                                <li><a href="{{url('/vendor/customer/'.$client->id.'/billing')}}">Billing</a></li>
                                <li><a href="{{url('/vendor/customer/'.$client->id.'/documents')}}" >Documents</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active mt-3" id="1">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"> 
                                            <div class="top-title" style="display: flex; justify-content: space-between; align-items: center;"> 
                                                <h3>Customer Details</h3> 
                                               <button type="button" onclick="openEditPopup({{ $client->id }});" class="btn btn-primary">
                                                    <i class="fa fa-edit"></i> Edit Customer
                                                </button>

                                            </div> 
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Business Name:</strong></p>
                                                    <p>{{$client->business_name}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Name:</strong></p>
                                                    <p>{{$client->first_name." ".$client->last_name}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Phone:</strong></p>
                                                    <p>{{$client->phone}}</p>
                                                </div>
                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Email:</strong></p>
                                                    <p>{{$client->email}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Address:</strong></p>
                                                    <p>{{$client->address}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>City:</strong></p>
                                                    <p>{{$client->city}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>State:</strong></p>
                                                    <p>{{$client->Province_State}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Post Code:</strong></p>
                                                    <p>{{$client->zip}}</p>
                                                </div>
                                                
                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Customer Type:</strong></p>
                                                    <p>{{$client->customer_type}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Department:</strong></p>
                                                    <p>{{$client->department}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Status:</strong></p>
                                                    <p>{{$client->status_stages}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Payment Method:</strong></p>
                                                    <p>{{$client->payment_method}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Tax Group:</strong></p>
                                                    <p>{{$client->TAX_GROUP}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Source:</strong></p>
                                                    <p>{{$client->source}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Invoicing:</strong></p>
                                                    <p>{{$client->invoicing_type}}</p>
                                                </div>

                                                <div class="mt-2 col-md-4">
                                                    <p><strong>Account Manager:</strong></p>
                                                    <p>{{$client->Account_Manager}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane mt-3" id="2">
                                </div>
                                <div class="tab-pane mt-3" id="3">
                                </div>
                            </div>
                            <a href="/vendor/customer/{{$client->id}}/add-job" class="btn btn-success float-right my-2">Add New Job</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="blockUI blockMsg blockPage" style="z-index: 1011; display:none; position: fixed !important; width: 100%; max-width: 1000px; left: 50%; top: 50%; transform: translate(-50%, -50%);" id="updateCustomerForm">
        <div class="background-container" style="position: relative; width: 100%;">
            <!-- Close button at top right corner -->
            <button type="button" class="close-box-button" style="position: absolute; top: 10px; right: 15px; z-index: 2; background: transparent; border: none; font-size: 24px;">&times;</button>
            <h3 style="text-align:center;">Edit Customer</h3>
            <form action="{{ route('vendor.customer_update') }}" role="form" class="form-horizontal" id="ClientHomeForm" method="post" accept-charset="utf-8" style="width: 100%;">
                {{ csrf_field() }}
                <input type="hidden" name="hf_client_id" class="form-control" id="hf_client_id" value="">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group row">
                            <label for="BUSINESS_NAME" class="col-sm-4 col-form-label">Business Name</label>
                            <div class="col-sm-8">
                                <input name="txt_business_name" class="form-control" placeholder="Business Name" id="txt_business_name" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="CONTACT_FIRST_NAME" class="col-sm-4 col-form-label">First Name *</label>
                            <div class="col-sm-8">
                                <input name="txt_first_name" class="form-control" placeholder="First Name" id="txt_first_name" required type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="CONTACT_LAST_NAME" class="col-sm-4 col-form-label">Last Name *</label>
                            <div class="col-sm-8">
                                <input name="txt_last_name" class="form-control" placeholder="Last Name" id="txt_last_name" required type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="customer_type">Customer Type *</label>
                            <div class="col-sm-8">
                                <select name="txt_customer_type" class="form-control" id="txt_customer_type" required>
                                    <option value="">Select Customer Type</option>
                                    <option value="Contract">Contract</option>
                                    <option value="Purge">Purge</option>
                                    <option value="Drop Off">Drop Off</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="department" class="col-sm-4 col-form-label">Department *</label>
                            <div class="col-sm-8">
                                <input name="txt_department" class="form-control" placeholder="Department" id="txt_department" required type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="status">Status *</label>
                            <div class="col-sm-8">
                                <select name="txt_status_stages" class="form-control" id="txt_status_stages" required>
                                    <option value="">Select Status</option>
                                    <option value="Prospect">Prospect</option>
                                    <option value="Lead">Lead</option>
                                    <option value="Customer">Customer</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="payment_method">Payment Method *</label>
                            <div class="col-sm-8">
                                <select name="txt_payment_method" class="form-control" id="txt_payment_method" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Paypal">Paypal</option>
                                    <option value="Credit">Credit</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="tax_group">Tax Group *</label>
                            <div class="col-sm-8">
                                <select name="txt_tax_group" class="form-control" id="txt_tax_group" required>
                                    <option value="">Select Tax Group</option>
                                    @foreach($tax_groups as $group)
                                        <option value="{{ $group->GROUP_NAME }}">{{ $group->GROUP_NAME }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="source">Source *</label>
                            <div class="col-sm-8">
                                <select name="txt_source" class="form-control" id="txt_source" required>
                                    <option value="">Select Source</option>
                                    <option value="Online">Online</option>
                                    <option value="Referral">Referral</option>
                                    <option value="Phone">Phone</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Second column -->
                    <div class="col-md-6 col-12">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="invoicing">Invoicing *</label>
                            <div class="col-sm-8">
                                <select name="txt_invoicing_type" class="form-control" id="txt_invoicing_type" required>
                                    <option value="">Select Invoicing</option>
                                    <option value="Single">Single</option>
                                    <option value="Batch">Batch</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="manager">Account Manager *</label>
                            <div class="col-sm-8">
                                <select name="txt_manager" class="form-control" id="txt_manager" required>
                                    <option value="">Select Account Manager</option>
                                    @foreach($account_managers as $manager)
                                        <option value="{{ $manager->FULL_NAME }}">{{ $manager->FULL_NAME }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="EMAIL" class="col-sm-4 col-form-label">E-mail *</label>
                            <div class="col-sm-8">
                                <input name="txt_email" class="form-control" placeholder="Email" required id="txt_email" type="email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="PHONE" class="col-sm-4 col-form-label">Phone</label>
                            <div class="col-sm-2 col-4 pr-1">
                                <input name="txt_phone1" class="form-control" maxlength="3" placeholder="000" id="txt_phone1" type="text">
                            </div>
                            <div class="col-sm-2 col-4 pr-1">
                                <input name="txt_phone2" class="form-control" maxlength="3" placeholder="000" id="txt_phone2" type="text">
                            </div>
                            <div class="col-sm-4 col-4">
                                <input name="txt_phone3" class="form-control" maxlength="4" placeholder="0000" id="txt_phone3" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="STREET_ADDR1" class="col-sm-4 col-form-label">Address</label>
                            <div class="col-sm-8">
                                <input name="txt_address" class="form-control" placeholder="Address" id="txt_address" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="address">Country</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="txt_country" id="txt_country" placeholder="Country">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="CITY" class="col-sm-4 col-form-label">City</label>
                            <div class="col-sm-8">
                                <input name="txt_city" class="form-control" placeholder="City" id="txt_city" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="PROVINCE" class="col-sm-4 col-form-label">Province</label>
                            <div class="col-sm-8">
                                <select name="cmb_province" class="form-control" id="cmb_province">
                                    <option value="">Select Province</option>
                                    <option value="Alberta">Alberta</option>
                                    <option value="British Columbia">British Columbia</option>
                                    <option value="Manitoba">Manitoba</option>
                                    <option value="New Brunswick">New Brunswick</option>
                                    <option value="Newfoundland">Newfoundland</option>
                                    <option value="Northwest Territorie">Northwest Territorie</option>
                                    <option value="Nova Scotia">Nova Scotia</option>
                                    <option value="Nunavut">Nunavut</option>
                                    <option value="Ontario">Ontario</option>
                                    <option value="Prince Edward Island">Prince Edward Island</option>
                                    <option value="Quebec">Quebec</option>
                                    <option value="Saskatchewan">Saskatchewan</option>
                                    <option value="Yukon">Yukon</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ClientPostalCode1" class="col-sm-4 col-form-label">Postal Code</label>
                            <div class="col-sm-4 col-6 pr-1">
                                <input name="txt_fsa1" class="form-control" maxlength="3" id="txt_fsa1" type="text">
                            </div>
                            <div class="col-sm-4 col-6">
                                <input name="txt_fsa2" class="form-control" maxlength="3" id="txt_fsa2" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center" style="margin-top:20px;">
                    <button class="btn btn-inverse close-box-button" type="reset">Cancel</button>
                    &nbsp;
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @media (max-width: 767.98px) {
            #updateCustomerForm {
                max-width: 90vw !important;
                width: 90vw !important;
                left: 50% !important;
                top: 50% !important;
                transform: translate(-50%, -50%) !important;
                border-radius: 10px !important;
                margin: 0 !important;
                height: 90vh !important;
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch !important;
            }
            #updateCustomerForm .background-container {
                padding: 10px !important;
            }
            #updateCustomerForm form .row {
                flex-direction: column;
            }
            #updateCustomerForm .col-md-6, #updateCustomerForm .col-12 {
                max-width: 100%;
                flex: 0 0 100%;
            }
            #updateCustomerForm .form-group.row {
                flex-direction: column;
                margin-bottom: 1rem;
            }
            #updateCustomerForm label.col-form-label, 
            #updateCustomerForm .col-sm-4.col-form-label {
                width: 100%;
                text-align: left;
                margin-bottom: 0.25rem;
            }
            #updateCustomerForm .col-sm-8, 
            #updateCustomerForm .col-sm-4, 
            #updateCustomerForm .col-sm-2, 
            #updateCustomerForm .col-sm-3 {
                width: 100%;
                max-width: 100%;
                padding-right: 0;
                padding-left: 0;
            }
            #updateCustomerForm .form-group .row > div {
                padding-right: 0;
                padding-left: 0;
            }
            #updateCustomerForm .form-group .col-4, 
            #updateCustomerForm .form-group .col-6 {
                width: 48%;
                display: inline-block;
            }
            #updateCustomerForm .form-group .col-4:last-child, 
            #updateCustomerForm .form-group .col-6:last-child {
                width: 48%;
                margin-left: 2%;
            }
            #updateCustomerForm .text-center {
                text-align: center !important;
            }
        }
        /* Always allow vertical scroll for modal content */
        #updateCustomerForm {
            overflow-y: auto !important;
            max-height: 90vh;
        }
        #updateCustomerForm .background-container {
            max-height: 100%;
            overflow-y: auto;
        }
    </style>



    <script>


 $(document).ready(function() {

        $.blockUI.defaults = {

            message: '&lt;h1&gt;Please wait...&lt;/h1&gt;',

            title: null,

            draggable: true,

            theme: false,

            css: {
                padding: 0,
                margin: 0,
                width: '45%',
                top: '10%',
                left: '30%',
                textAlign: 'center',
                color: '#000',
                border: '3px solid #aaa',
                backgroundColor: '#fff'
                //cursor: 'wait'
            },

            themedCSS: {
                width: '30%',
                top: '40%',
                left: '35%'
            },

            overlayCSS: {
                backgroundColor: '#000',
                opacity: 0.6
                //cursor: 'wait'
            },

            cursorReset: 'default',

            growlCSS: {
                width: '350px',
                top: '10px',
                left: '',
                right: '10px',
                border: 'none',
                padding: '5px',
                opacity: 0.6,
                cursor: null,
                color: '#fff',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px'
            },

            iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank',

            forceIframe: false,

            baseZ: 1000,

            centerX: true,

            centerY: true,

            allowBodyStretch: true,

            bindEvents: true,

            constrainTabKey: true,

            fadeIn: 200,

            fadeOut: 400,

            timeout: 0,

            showOverlay: true,

            focusInput: true,

            onBlock: null,

            onUnblock: null,

            quirksmodeOffsetHack: 4,

            blockMsgClass: 'blockMsg',

            ignoreIfBlocked: false
        };



        /*$('.btn-next').click(function(){
            var next_step = $(this).data('next');
            if(next_step == "step2"){
                $('.step-pane.step1').hide();
                $("li[data-target='step1']").removeClass('active');
                $('.step-pane.step2').show();
                $("li[data-target='step2']").addClass('active');
            }
        });*/

        $('.js-select_button').click(function() {
            var next_step = $(this).data('next');
            if (next_step == "step2") {
                $('.step-pane.step1').hide();
                $("li[data-target='step1']").removeClass('active');
                $('.step-pane.step2').show();
                $("li[data-target='step2']").addClass('active');
            }
        });

        $('.btn-prev').click(function() {
            var prev_step = $(this).data('prev');
            if (prev_step == "step1") {
                $('.step-pane.step2').hide();
                $("li[data-target='step2']").removeClass('active');
                $('.step-pane.step1').show();
                $("li[data-target='step1']").addClass('active');
            }
        });

        $('#txt_search_by_name').keypress(function(e) {

            var search_length = $(this).val().trim().length;

            var key = e.which;
            if (key == 13) {
                if (search_length < 3) {
                    $('.resultsMessage').show();
                    $(".resultsTable").hide();
                } else {
                    $.ajax({
                        type: "GET",
                        url: '',
                        data: {
                            'keyword': $(this).val()
                        },
                        success: function(data) {
                            $('.resultsMessage').hide();
                            $(".resultsTable").show();
                            $(".resultsTable").html(data);
                        }
                    });
                }
            }
        });

        $('#txt_search_by_phone').keypress(function(e) {

            var search_length = $(this).val().trim().length;

            var key = e.which;
            if (key == 13) {
                if (search_length < 3) {
                    $('.resultsMessage').show();
                    $(".resultsTable").hide();
                } else {
                    $.ajax({
                        type: "GET",
                        url: '',
                        data: {
                            'phone': $(this).val()
                        },
                        success: function(data) {
                            $('.resultsMessage').hide();
                            $(".resultsTable").show();
                            $(".resultsTable").html(data);
                        }
                    });
                }
            }
        });

        $('#doSearch').click(function() {
            var search_name_length = $('#txt_search_by_name').val().trim().length;
            var search_phone_length = $('#txt_search_by_phone').val().trim().length;
            if (search_name_length < 3 && search_phone_length < 3) {
                $('.resultsMessage').show();
                $(".resultsTable").hide();
            } else {
                $.ajax({
                    type: "GET",
                    url: '<?php echo route('get_ajax_search_client'); ?>',
                    data: {
                        'keyword': $('#txt_search_by_name').val(),
                        'phone': $('#txt_search_by_phone').val()
                    },
                    success: function(data) {
                        $('.resultsMessage').hide();
                        $(".resultsTable").show();
                        $(".resultsTable").html(data);
                    }
                });
            }
        });

        $(".close-box-button").click(function() {
            $.unblockUI();
        });

        $("#zip").keyup(function() {
            var val = $(this).val();
            if (val.length == 3) {
                $('#zip2').focus();
            }
        });

        $("#txt_fsa1").keyup(function() {
            var val = $(this).val();
            if (val.length == 3) {
                $('#txt_fsa2').focus();
            }
        });

        $("#phone1").keyup(function() {
            var val = $(this).val();
            if (val.length == 3) {
                $('#phone2').focus();
            }
        });

        $("#phone2").keyup(function() {
            var val = $(this).val();
            if (val.length == 3) {
                $('#phone3').focus();
            }
        });

        $("#txt_phone1").keyup(function() {
            var val = $(this).val();
            if (val.length == 3) {
                $('#txt_phone2').focus();
            }
        });

        $("#txt_phone2").keyup(function() {
            var val = $(this).val();
            if (val.length == 3) {
                $('#txt_phone3').focus();
            }
        });
    });


    
        $(function () {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: '{{ url('vendor/get-template-ajax') }}/{{$client->id}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'job_type_id', name: 'job_type_id'},
                    {data: 'repeat', name: 'repeat'},
                    {data: 'schedule_from', name: 'schedule_from'},
                    {data: 'action', name: 'action', searchable: false}
                ]
            });
        });

        function openEditPopup(client_id) {
        $.ajax({
            type: "GET",
            url: '<?php echo url('/vendor/customer/get_ajax_client'); ?>',
            data: {
                'client_id': client_id
            },
            success: function(data) {
                var client = JSON.parse(data);
                $('#hf_client_id').val(client['id']);
                $('#txt_business_name').val(client['business_name']);
                $('#txt_first_name').val(client['first_name']);
                $('#txt_last_name').val(client['last_name']);
                // $('#txt_gender').val(client['gender']);
                $('#txt_email').val(client['email']);
                //$('#txt_phone').val(client['PHONE']);
                $('#txt_phone1').val(client['phone'].substring(0, 3));
                $('#txt_phone2').val(client['phone'].substring(3, 6));
                $('#txt_phone3').val(client['phone'].substring(6, 10));
                $('#txt_address').val(client['address']);
                $('#txt_country').val(client['Country']);
                $('#txt_city').val(client['city']);
                $('#cmb_province').val(client['Province_State']);
                $('#txt_fsa1').val(client['zip'].substring(0, 3));
                $('#txt_fsa2').val(client['zip'].substring(3, 6));


                $('#txt_department').val(client['department']);
                $('#txt_payment_method').val(client['payment_method']);
                $('#txt_tax_group').val(client['TAX_GROUP']);
                $('#txt_source').val(client['source']);
                $('#txt_invoicing_type').val(client['invoicing_type']);
                $('#txt_manager').val(client['Account_Manager']);
                $('#txt_customer_type').val(client['customer_type']);
                $('#txt_status_stages').val(client['status_stages']);

                $.blockUI({
                    message: $('#updateCustomerForm')
                });
            }
        });
    }


    </script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="http://cdn.datatables.net/plug-ins/1.10.15/dataRender/datetime.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

@stop

@section('footer')

@stop