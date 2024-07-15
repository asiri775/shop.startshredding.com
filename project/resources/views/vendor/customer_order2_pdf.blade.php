<!DOCTYPE html>
<html>    
<head>
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        .w-100 {
            width: 51% !important;
        }

        .w-50 {
            width: 25% !important;
        }
    </style>
</head>
<body>
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
                    <div class="row col-md-12">
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
                    </div>
                    <div class="row col-md-12">
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
                    </div>               
                    <div class="col-md-12 row">
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
                            if($products){
                                $total = 0.00;
                            foreach ($products As $product){

                            $productDetails=$product->getProductidAttribute($product->productid);
                            if($productDetails){
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
                            <?php }} ?>
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
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>