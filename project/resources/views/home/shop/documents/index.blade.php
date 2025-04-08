@extends('home.shop.user.new_main')
@section('title','My Documents')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid p-b-50 m-t-40">
            <div class="col-md-12 card card-borderless">
                <div class="row">
                    @if (Session::has('message'))
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    @if(Session::has('errors'))
                        <div class="alert alert-danger alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif

                    <style>
                        .col-heading {
                            color: #fff!important;
                        }
                    </style>
                </div>
                <div class="row">
                    
                    <div class="col-sm-12 p-b-5" style="border-color: black !important">
                        <div class="card card-default">
                            <div class="padding-25">
                                <div class="pull-left">
                                    <div class="no-margin ube-card-title">My documents</div>
                                    <p class="no-margin">Documents Details</p>
                                </div>

                                <div class="clearfix">
                                    
                                </div>
                                
                            </div>
                            <div class="table-reponsive container">
                                <table data-export="1,2,3,4,5,6,7,8" cellpadding="0" cellspacing="0" id="table_1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr class="text-center">
                                        <th style=" white-space: nowrap;" class="all-caps col-heading">Order ID</th>
                                        <th  class="all-caps col-heading">Service Date</th>
                                        <th  class="all-caps col-heading">Client</th>
                                        <th  class="all-caps col-heading">Amount</th>
                                        <th class="all-caps col-heading">Status <i class="fa fa-question-circle" style="color:white;" aria-hidden="true"></i></th>
                                        <th  class="all-caps col-heading">Action</th> 
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($documents as $document)
                                        <!-- @if($document->sa_state == 1) -->
                                        <tr class="text-center">
                                            <td class="fs-12">{{$document->order_id}}</td>
                                            <td class="fs-12">{{date('m/d/Y', strtotime($document->booking_date))}}</td>
                                            <td class="fs-12">{{$document->contact_name}}</td>
                                            <td class="fs-12">{{$settings[0]->currency_sign}}{{number_format($document->pay_amount, 2)}}</td>
                                            <td class="fs-12">
                                                <a href="{!!url('/shop-documents/'.$document->order_id)!!}" class="btn complete-btn btn-success btn-cons btn-block"
                                                        type="button"><span>Completed</span>
                                                </a>
                                            </td>
                                            <td class="fs-12">
                                                <a href="" class="btn btn-warning">
                                                    <i class="fa fa-envelope"></i>
                                                </a>
                                                <a href="{!!url('/document_download/'.$document->order_id)!!}" class="btn btn-info">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <a href="{!!url('/document_print/'.$document->order_id)!!}" class="btn btn-primary">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                            </td>
                                            
                                        </tr>
                                        <!-- @endif -->
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        
                    </div>
                    

                </div>
            </div>
        </div>


        <!-- END CONTAINER FLUID -->

    </div>
    <!-- END PAGE CONTENT -->
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function (e) {
            $('#table_1').DataTable({
                dom: 'lBfrtip',
                select: true,
                ordering: true,
                "pageLength": 50,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    ['10', '25', '50', '100', 'All']
                ],
                order: [[1, 'desc']],
                buttons: [{
                        extend: 'excel',
                        text: '<i style="color:green" class="fa fa-file-excel-o fa-2x"></i>&nbsp; Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        title: 'Order History',
                    },
                    {
                        extend: 'csv',
                        text: '<i style="color:blue" class="fa fa-file-text-o fa-2x"></i>&nbsp; CSV',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        title: 'Order History',
                    },
                    {
                        extend: 'pdf',
                        text: '<i style="color:red" class="fa fa-file-pdf-o fa-2x"></i>&nbsp; PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        title: 'Order History',
                    },
                    {
                        extend: 'print',
                        text: '<i style="color:black" class="fa fa-print fa-2x"></i>&nbsp; Print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        title: 'Order History',
                    }
                ]
            });
        })
    </script>
    <!-- END PAGE LEVEL JS -->
@endsection