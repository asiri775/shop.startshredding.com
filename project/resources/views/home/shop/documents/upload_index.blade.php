@extends('vendor.includes.master-vendor')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <!-- START PAGE CONTENT -->
    <div class="page-title">
        <!-- START CONTAINER FLUID -->
        <div class="col-md-12">
            <div class="padding-25">
                <div class="pull-left">
                    <h2>Upload File</h2>
                    <p class="no-margin">File details</p>
                </div>

                <div class="clearfix">
                    
                </div>
            </div>
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
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table data-export="1,2,3,4,5,6,7,8" cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
                        <thead>
                        <tr class="text-center">
                            <th  class="all-caps">Date</th>
                            <th style=" white-space: nowrap;" class="all-caps">Order ID</th>
                            <th  class="all-caps">Document Type</th>
                            <th  class="all-caps">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                                <tr class="text-center">
                                    <td class="fs-12">{{date('m/d/Y', strtotime($document->order_date))}}</td>
                                    <td class="fs-12">{{$document->order_id}}</td>
                                    <td class="fs-12">{{$document->doc_type}}</td>
                                    <td class="fs-12"><a href="{{ route('file.download', ['id' => $document->id]) }}"><i class="fa fa-download" aria-hidden="true"></i></a>
                                    <a href="{!! url('/vendor/delete-document/'.$document->id)!!}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                
                <div class="">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('home.upload.document') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group form-group-default">
                                    <label for="order_number">Order Number:</label>
                                    <input type="text" id="order_number" class="form-control" value={{$order_id}} name="order_number" required>
                                </div>
                                <div class="form-group form-group-default">
                                    <label for="order_date">Order Date:</label>
                                    <input type="date" id="order_date" class="form-control" name="order_date" required>
                                </div>
                                <div class="form-group form-group-default">
                                    <label for="document">Attach Document:</label>
                                    <input type="file" id="document" class="form-control" name="document" required>
                                </div>
                                <div class="comments-form pull-right">
                                    <input type="submit" name="orderForm" class="btn btn-primary btn-cons" style="margin: 0;padding: 9px 30px;" value="Upload Document">
                                </div>
                            </form>
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
            
        })
    </script>
    <!-- END PAGE LEVEL JS -->
@endsection