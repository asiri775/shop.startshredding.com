@extends('vendor.includes.master-vendor')

@section('content')
    <link href="{{ URL::asset('assets/map/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/map/css/custom.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/map/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/map/css/bootstrap-4-utilities.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"></script>

    <style>
        .w-100 {
            width: 100% !important;
        }

        .order-id {
            max-width: 150px;
            padding-right: 15px;
        }

        .order-id label {
            margin: 8px 0px;
        }

        div.dt-buttons {
            float: unset;
            margin: 48px 14px 0 0;
        }

        .buttons-select-all, .buttons-select-none {
            text-transform: capitalize;
        }

        .btn-warning {
            color: #fff!important;
            background-color: #f0ad4e!important;
            border-color: #eea236!important;
            background-image: unset!important;
        }
        .btn-info {
            color: #fff!important;
            background-color: #5bc0de!important;
            border-color: #46b8da!important;
            background-image: unset!important;
        }
        .form-inline select.form-control {
         min-width: 100%!important;
      }
      .custom-calendar {
    margin-top: unset;
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
                                <li><a href="{{url('/vendor/customer/'.$client->id)}}">Overview</a></li>
                                <li><a href="{{url('/vendor/customer/'.$client->id.'/templates')}}">Templates</a></li>
                                <li><a href="{{url('/vendor/customer/'.$client->id.'/orders')}}">Orders</a></li>
                                <li class="active"><a href="{{url('/vendor/customer/'.$client->id.'/billing')}}">Billing</a></li>
                                <li><a href="{{url('/vendor/customer/'.$client->id.'/documents')}}">Documents</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane  mt-3" id="1"></div>
                                <div class="tab-pane mt-3" id="2"></div>
                                <div class="tab-pane mt-3" id="3"></div>
                                <div class="tab-pane active mt-3" id="4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="top-title">
                                                <h3>Credit Card</h3>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-12">
                                                <div class="card card-default">
                                                    <div class="invoice padding-20 sm-padding-10">
                                                        <div class="card-body p-t-20">
                                                            <form action="{{route('home.credit.add')}}" method="POST">
                                                                {{ csrf_field() }}
                                                                <input value="{{$client->id}}" name = "client_id"  hidden>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label class="font-clr" style="color: #a832a4">ADD NEW CARD</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row justify-content-left">
                                                                
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <label class="font-clr font-sz">Cardholder_Name </label>
                                                                                    <div class="form-group form-group-default">
                                                                                        <input type="text" name="cardholder_name" id="cardholder_name" value="" class="form-control" required>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <label class="font-clr font-sz">Card_Number </label>
                                                                                    <div class="form-group form-group-default">
                                                                                        <!-- <input type="password" name="card_number" id="card_number" value="" class="form-control" > -->
                                                                                        <input type="text" class="form-control card-no" name="card_number" placeholder="8888 8888 8888 8888" size="18" id="cr_no" minlength="19" maxlength="19" required>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <label class="font-clr font-sz">EXPIRY(MM) </label>
                                                                                    <div class="form-group form-group-default">
                                                                                        <!-- <input type="text" nname="route" id="route" value="" class="form-control"> -->
                                                                                        <select class="form-control" name="exp_month" required>
                                                                                            <option value="1">Jan (01)</option>
                                                                                            <option value="2">Feb (02)</option>
                                                                                            <option value="3">Mar (03)</option>
                                                                                            <option value="4">Apr (04)</option>
                                                                                            <option value="5">May (05)</option>
                                                                                            <option value="6">Jun (06)</option>
                                                                                            <option value="7">Jul (07)</option>
                                                                                            <option value="8">Aug (08)</option>
                                                                                            <option value="9">Sep (09)</option>
                                                                                            <option value="10">Oct (10)</option>
                                                                                            <option value="11">Nov (11)</option>
                                                                                            <option value="12">Dec (12)</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <label class="font-clr font-sz">EXPIRY(YY) </label>
                                                                                    <div class="form-group form-group-default">
                                                                                        <!-- <input type="text" nname="route" id="route" value="" class="form-control"> -->
                                                                                        <select class="form-control" name="exp_year" required>
                                                                                            <option>2024</option>
                                                                                            <option>2025</option>
                                                                                            <option>2026</option>
                                                                                            <option>2027</option>
                                                                                            <option>2028</option>
                                                                                            <option>2029</option>
                                                                                            <option>2030</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <label class="font-clr font-sz">CCV Code</label>
                                                                                    <div class="form-group form-group-default">
                                                                                        <input type="text" name="ccv" id="ccv" placeholder="000" minlength="3" maxlength="3" value="" class="form-control" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-11">
                                                                        <div class="btn-group pull-right">
                                                                            <button type="submit" style="background-color: #6232a8!important;" class="btn btn-success"><font style="font-size: 10px !important;">ADD CARDS</font>
                                                                            </button>

                                                                        </div>
                                                                    </div>
                                                                        

                                                                </div>
                                                            </form>

                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label class="font-clr" style="color: #a832a4">MANAGE CARDS </label>
                                                                </div>

                                                            </div>
                                                            @foreach($card_details as $card)
                                                                <div class="row">
                                                                    <div class="col-md-7">
                                                                        <div class="checkbox check-primary checkbox-circle">
                                                                            <label style="font-size: 10px !important;">CARD# {{$card -> card_number}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label class="font-clr">&nbsp</label>
                                                                        <div class="btn-group">
                                                                            <a href="{{url('/vendor/edit_credit/')}}/{{$card->id}}" style="background-color: #6232a8!important;" class="btn btn-success btn-size"><font style="font-size: 10px !important;">Edit</font>
                                                                            </a>
                                                                            @if($card->is_primary == "0")
                                                                            <a href="{{url('/shop-billing-setting/set_primary/')}}/{{$card->id}}" style="background-color: #6232a8!important;" class="btn btn-success btn-size"><font style="font-size: 10px !important;">Set as Primary</font>
                                                                            </a>
                                                                            <a href="{{url('/shop-billing-setting/delete_credit/')}}/{{$card->id}}" style="background-color: #a832a4!important;" class="btn btn-success btn-size"><font style="font-size: 10px !important;">REMOVE</font>
                                                                            </a>
                                                                            @else
                                                                            <a href="#!" class=""><font style="font-size: 12px !important;">Primary Account</font>
                                                                            </a>
                                                                            <a href="{{url('/shop-billing-setting/delete_credit/')}}/{{$card->id}}" style="background-color: #a832a4!important;" class="btn btn-success btn-size"><font style="font-size: 10px !important;">REMOVE</font>
                                                                            </a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <br>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="col-md-12">
                                            <div class="card card-default">
                                                <div class="invoice padding-20 sm-padding-10">
                                                    
                                                    <div class="card-body p-t-20">
                                                        <form action="">
                                                            <div class="row justify-content-left">
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="display: inline-block">

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <h4><b>Credit Cards</b></h4>
                                                                                <p>Details</p>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>

                                                        <hr>
                                                        <div class="">
                                                            <table class="table table-hover table-condensed table-responsive table-responsive"
                                                                id="tableTransactions">
                                                                <thead bgcolor="#1f217d">
                                                                <tr>
                                                                    <!-- NOTE * : Inline Style Width For Table Cell is Required as it may differ from user to user
                                                                    Comman Practice Followed
                                                                    -->
                                                                    <th style="width:20%;"><font color="#fc7b03">id</font></th>
                                                                    <th style="width:20%;"><font color="#fc7b03">Cardholder_Name</font></th>
                                                                    <th style="width: 20%;"><font color="#fc7b03">Card_Number</font></th>
                                                                    <th style="width: 20%;"><font color="#fc7b03">Expiry</font></th>
                                                                    <th style="width: 20%;"><font color="#fc7b03">CCV</font></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($card_details as $card)
                                                                        <tr class="text-center">
                                                                            <td class="fs-12">{{ $card->id}}</td>
                                                                            <td class="fs-12">{{ $card->card_holder_name}}</td>
                                                                            <td class="fs-12">{{ $card->card_number}}</td>
                                                                            <td class="fs-12">{{$card->exp_month.'/'.$card->exp_year}}</td>
                                                                            <td class="fs-12">{{ $card->ccv}}</td>
                                                                        

                                                                            <!-- <td class="fs-12">{{ $card->is_primary }}</td> -->
                                                                            <!-- <td class="fs-12">{{$settings[0]->currency_sign}}{{ $card->amount }}</td> -->
                                                                            
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!--<div class="row">
                                                            <div class="col-md-2">
                                                                <input type="checkbox" value="1" id="checkbox1" required name="terms">
                                                                <label for="checkbox1" class="text-info small"> <a href="http://backpocket.ca/terms.html"
                                                                                                                class="text-info ">SELECT ALL</a></label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="checkbox" value="1" id="checkbox1" required name="terms">
                                                                <label for="checkbox1" class="text-info small"> <a href="http://backpocket.ca/terms.html"
                                                                                                                class="text-info ">
                                                                    DESELECT</a></label>
                                                            </div>

                                                        </div>-->

                                                    </div>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane mt-3" id="5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        
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
    

<script src="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js')}}"
    type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/datatables-responsive/js/datatables.responsive.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery-inputmask/jquery.inputmask.min.js')}}" type="text/javascript"></script>
<!-- END VENDOR JS -->
<!-- BEGIN CORE TEMPLATE JS -->
<!-- BEGIN CORE TEMPLATE JS -->
<script src="{{ URL::asset('new_assets/pages/js/pages.js')}}"></script>
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<!-- <script src="{{ URL::asset('new_assets/assets/js/scripts.js')}}" type="text/javascript"></script> -->
<!-- END PAGE LEVEL JS -->
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<!-- <script src="assets/js/dashboard.js" type="text/javascript"></script> -->
<script>
    $(document).ready(function (e) {
    //For Card Number formatted input
        var cardNum = document.getElementById('cr_no');
        cardNum.onkeyup = function (e) {
            if (this.value == this.lastValue) return;
            var caretPosition = this.selectionStart;
            var sanitizedValue = this.value.replace(/[^0-9]/gi, '');
            var parts = [];
            
            for (var i = 0, len = sanitizedValue.length; i < len; i += 4) {
                parts.push(sanitizedValue.substring(i, i + 4));
            }
            
            for (var i = caretPosition - 1; i >= 0; i--) {
                var c = this.value[i];
                if (c < '0' || c > '9') {
                    caretPosition--;
                }
            }
            caretPosition += Math.floor(caretPosition / 4);
            
            this.value = this.lastValue = parts.join(' ');
            this.selectionStart = this.selectionEnd = caretPosition;
        }


        var table = $('#tableTransactions');
        table.dataTable({
            "sDom": "<t><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 5
        });

        // var _format = function (d) {
        //     // `d` is the original data object for the row
        //     return '<table class="table table-inline">' +
        //         '<tr>' +
        //         '<td>Learn from real test data <span class="label label-important">ALERT!</span></td>' +
        //         '<td>USD 1000</td>' +
        //         '</tr>' +
        //         '<tr>' +
        //         '<td>PSDs included</td>' +
        //         '<td>USD 3000</td>' +
        //         '</tr>' +
        //         '<tr>' +
        //         '<td>Extra info</td>' +
        //         '<td>USD 2400</td>' +
        //         '</tr>' +
        //         '</table>';
        // }

        // // Add event listener for opening and closing details
        // $('#tableTransactions tbody').on('click', 'tr', function () {
        //     //var row = $(this).parent()
        //     if ($(this).hasClass('shown') && $(this).next().hasClass('row-details')) {
        //         $(this).removeClass('shown');
        //         $(this).next().remove();
        //         return;
        //     }
        //     var tr = $(this).closest('tr');
        //     var row = table.DataTable().row(tr);

        //     $(this).parents('tbody').find('.shown').removeClass('shown');
        //     $(this).parents('tbody').find('.row-details').remove();

        //     row.child(_format(row.data())).show();
        //     tr.addClass('shown');
        //     tr.next().addClass('row-details');
        // });

        //Date Pickers
        $('#daterangepicker').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            format: 'MM/DD/YYYY h:mm A'
        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>

@stop

@section('footer')

@stop