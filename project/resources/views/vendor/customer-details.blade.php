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
                                                <a href="{{ route('vendor.customer.edit', ['id' => $client->id]) }}" class="btn btn-primary"><i class="fa fa-edit">
                                                    </i> Edit Customer
                                                </a>

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