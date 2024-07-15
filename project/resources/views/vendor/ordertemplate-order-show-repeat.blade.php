@extends('vendor.includes.master-vendor')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <style>
        .w-100 {
            width: 51% !important;
        }

        .w-50 {
            width: 25% !important;
        }
    </style>
    <div class="page-title row">
        <h2>Booking Date: {{date('Y-m-d', strtotime($order->booking_date))}}</h2>
        <div style="float: right;">
        </div>
    </div>
    <div class="bg-white row">
        <div class="panel-body-custom tableContainParent panel col-md-12 col-lg-12 col-sm-12 left-tab">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="top-title">
                        <h3>Order Details</h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="mt-2 col-md-4">
                            <p><strong>ID:</strong></p>
                            <p>{{$order->id}}</p>
                        </div>

                        <div class="mt-2 col-md-4">
                            <p><strong>Payment Method:</strong></p>
                            <p>{{$order->method}}</p>
                        </div>

                        <div class="mt-2 col-md-4">
                            <p><strong>Payment Status:</strong></p>
                            <p>{{$order->payment_status }}</p>
                        </div>
                        <div class="mt-2 col-md-4">
                            <p><strong><u>Billing Address</u></strong></p>
                            <p>{{$order->customer_name }}</p>
                            <p>{{$order->customer_address }}</p>
                            <p>{{$order->customer_city }}</p>
                            <p>{{$order->customer_zip }}</p>
                            <p>{{$order->customer_phone }}</p>
                        </div>
                        <div class="mt-2 col-md-4">
                            <p><strong><u>Shipping Address</u></strong></p>
                            <p>{{$order->shipping_name }}</p>
                            <p>{{$order->shipping_address }}</p>
                            <p>{{$order->shipping_city }}</p>
                            <p>{{$order->shipping_zip }}</p>
                            <p>{{$order->shipping_phone }}</p>
                        </div>
<br/>
                        <div class="panel-body-custom tableContainParent panel col-md-12 col-lg-12 col-sm-12 ">
                            <div class="table-responsive">
                                <div id="example_wrapper" class="dataTables_wrapper no-footer">
                                    <table class="table table-bordered w-100">
                                        <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>QTY</th>
                                            <th>Sub Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $total=0.00;
                                        foreach ($products As $product){
                                        ?>
                                        <tr>
                                            <td>{{$product->item_note}}</td>
                                            <td>{{number_format((float)$product->base_price, 2, '.', '')}}</td>
                                            <td>{{$product->qty}}</td>
                                            <?php
                                            $sub_total=$product->base_price*$product->qty;
                                            $total=$sub_total+$total;
                                            ?>
                                            <td>{{number_format((float)$sub_total, 2, '.', '')}}</td>

                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td><b>Tax</b></td>
                                            <td><b>{{number_format((float)$total*0.13, 2, '.', '')}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td><b>Total</b></td>
                                            <td><b>{{number_format((float)($total*0.13+$total), 2, '.', '')}}</b></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <a href="/vendor/customer/{{$order->customerid}}/orders" class="btn btn-success float-right my-2">Back To Customer
                orders</a>
            <a class="btn btn-primary btn-right"
                onclick="printPage( '{{route('vendor.customer_order.print', ['id' => $order->id])}}' )"
                href="javascript:void(0);"></i> <span class="bold">PRINT</span></a>
            <button id="download-btn"
                    class="btn btn-success btn-right"
                    type="button"><i class="fa fa-download"></i> <span class="bold">DOWNLOAD</span>
            </button>
            <?php
                $service_agreement = App\ServiceAgreement::where('order_id', $order->id)->first();
            ?>
            @if(is_null($service_agreement) || $service_agreement->sa_state == "0" )
                <a  style="background-color: #6232a8!important;" id="sa_link" class="btn btn-success">Send Agreement</a>
                <button href="" class="btn btn-success" type="button" style="background-color: #D3D3D3!important;" disabled>View Agreement</button>
            @elseif($service_agreement->sa_state == 1)
                <button  class="btn" type="button" style="background-color: #D3D3D3!important;"  disabled>Send Agreement</button>
                <a href="{!! url('vendor/service_agreement/'.$order->id) !!}" class="btn btn-success">View Agreement</a>
            @endif
            @if(isset($order->template_id))
                <a href="{!! url('vendor/order-template/'.$order->template_id) !!}" class="btn btn-success">View Template</a>                          
            @endif
        </div>
    </div>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"
            type="text/javascript"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(function () {
            $('#sa_link').click(function sa_link(){
            $.blockUI({ message: '<img src="{{asset('/assets/images/loader.gif')}}"/>', css: {
				padding:	0,
				margin:		0,
				width:		'30%',
				top:		'40%',
				left:		'35%',
				textAlign:	'center',
				color:		'',
				border:		'',
				backgroundColor:'',
				cursor:		'wait'
			},});
            $.post('/vendor/sa_link',
            {
                _token: "<?php echo csrf_token(); ?>",
                id: "<?php echo $order->id ?>"
            },
            function(data, status){
                $.unblockUI();
                var text = JSON.parse(data);
                if(text.message != undefined){
                    toastr.options.timeOut = 1500;
                    toastr.success(text.message);
                }
                console.log(text.errors);
                if(text.errors != undefined){
                    toastr.options.timeOut = 1500;
                    toastr.error(text.errors);
                }
            });
        });
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax: '/vendor/get-template-ajax',
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
        var increment = 1;
        var laravelToken = "{!! csrf_token() !!}";
        var options = {!! json_encode($products) !!};

        function printPage(url) {
            if (url) {
                var w = window.open(url, 'print page', 'height=900,width=800');
                if (window.focus) {
                    w.focus()
                }
                w.window.print();
                setTimeout(function () {
                    w.window.close();
                }, 2000);
                return false;
            }
        }

        $("#download-btn").click(function (e) {
            e.preventDefault();  //stop the browser from following
            window.location.href = '/vendor/customer_order_download/<?php echo $order->id;?>';
        });

        function addItem() {
            $('.item-tbody').append(
                '<tr id="' + "row" + increment + '">'
                + '<td><select  name="item[' + increment + '][product_id]">' +
                '<option value="">Select Product</option></select>' +
                '</td>'
                + '<td><input type="textarea" name="item[' + increment + '][item_note]"/></td>'
                + '<td><input type="text" name="item[' + increment + '][qty]"/></td>'
                + '<td><input type="text" class="price" name="item[' + increment + '][base_price]"/></td>'
                + '<td><a href="javascript:void(0);" onclick="$(this).parent().parent().remove();"'
                + 'class="btn btn-danger float-right">'
                + '<i class="glyphicon glyphicon-minus-sign"></i> remove</a></td>'
                + '</tr>'
            );
            $.each(options, function (value, key) {
                $("#row" + increment).find('select')
                    .append($("<option></option>")
                        .attr("value", key)
                        .text(value));
            });
            increment++;
        }

        $('table').on('change', "select", function () {
            var self = this;
            $.ajax({
                url: "/vendor/template-product/get-price",
                method: "POST", //First change type to method here

                data: {
                    id: this.value, // Second add quotes on the value.
                    _token: laravelToken
                },
                success: function (response) {
                    console.log(response);
                    jQuery(self).parent().parent().find(".price").val(response);
                },
                error: function () {
                    alert("Something went wrong!");
                }

            });
        });
        $('input[name="dates"]').daterangepicker({
            minDate: moment()
        });
        $('input[name="date"]').datepicker({
            minDate: moment()
        });
    </script>
@stop

@section('footer')

@stop