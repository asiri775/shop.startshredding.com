@extends('admin.includes.master-admin')
@section('content')

    <style>
        .suggesstion-box {
            position: absolute;
            z-index: 1;
            width: 90%;
        }

        .suggesstion-box li {
            list-style: none;
            /* background: lavender; */
            background: lavender;
            padding: 4px;
            margin-bottom: 1px;
            overflow-wrap: break-word;
        }

        .suggesstion-box li:hover {
            cursor: pointer;
        }

        .dataTables_filter {
            display: none;
        }

        .chosen-single {
            height: 100px;
        }
    </style>

    <script src="{{ URL::asset('assets/map/js/jquery1.11.3.min.js') }}"></script>


    <div id="page-wrapper">

        <div class="container-fluid">
            <div class="row" id="main">

                <div class="go-title">
                    <div class="pull-right">
                        <a href="{!! url('admin/agreement/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Agreement</a>
                    </div>
                    <h3>Service Agreement List</h3>
                    <div class="go-line"></div>
                </div>


                
                <!-- Page Content -->
                <div class="panel panel-default">
                    

                    <div class="panel-body">
                        <div id="response">
                            @if (Session::has('message'))
                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                        </div>

                        <div class="row" id="mainTable">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered nowrap" cellspacing="0" id="cusTable"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Is Default</th>
                                            <th width="20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($greement_list as $agreement)
                                            <tr>
                                                <td>{{$agreement->name}}</td>
                                                <td>
                                                    {{ $agreement->is_default ? 'Yes' : 'No' }}
                                                </td>
                                

                                                <td>

                                              
                                                    <a href="{{ url('/admin/agreement/edit') }}/{{ $agreement->id }}"
                                                        class="btn btn-primary btn-xs"><i class="fa fa-check"></i>
                                                        Edit
                                                        Details </a>


                                                    <a href="javascript:;"
                                                        class="btn btn-danger btn-xs btn-delete"
                                                        data-href="{{ url('/') }}/admin/agreement/destroy/{{ $agreement->id }}"
                                                        data-id="{{ $agreement->id }}"
                                                        data-toggle="modal"
                                                        data-target="#confirm-delete">
                                                        <i class="fa fa-trash"></i> Remove
                                                    </a>
                                                        
                                                </td> 
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Confirm Delete</h4>
                            </div>
                            <div class="modal-body">
                                <p>You are about to delete this Agreement. Do you want to proceed?</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" id="btn-confirm-delete">Delete</button>
                            </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <script>

        let deleteUrl = '';
        let deleteId = null;

        $(document).on('click', '.btn-delete', function () {
            deleteUrl = $(this).data('href');
            deleteId = $(this).data('id');
        });

        
        $('#btn-confirm-delete').on('click', function(e) {
            if (!deleteUrl || !deleteId) {
                alert('Delete URL or ID is missing.');
                return;
            }
        
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    _method: 'DELETE', // Laravel spoofing
                    _token: '{{ csrf_token() }}',
                    id: deleteId // Pass the ID explicitly
                },
                success: function(response) {
                    swal("Success", "Agreement deleted successfully.", "success");
                    location.reload();
                },
                error: function(xhr) {
                    swal("Error", "Something went wrong.", "error");
                }
            });
        
            $('#confirm-delete').modal('hide');
        });
        
        
        $(function() {
            $(".chzn-select").chosen();
        });

        // AJAX call for Customer autocomplete 
        $(document).ready(function() {
            $("#city").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: '<?php echo url('/searchAjaxCities'); ?>',
                    data: {
                        'keyword': $('#city').val()
                    },
                    success: function(data) {
                        $("#citySearchBox").show();
                        $("#citySearchBox").html(data);
                    }
                });
            });
        });

        function selectCity($val) {
            $("#city").val($val);
            $("#citySearchBox").hide();
        }

        $(document).ready(function() {
            $('#cusTable').DataTable({
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, -1],
                    [50, 100, 200, "All"]
                ],
                "scrollX": true,
                "scrollY": "300px",
            });

            var table = $('#cusTable').DataTable();

            // #myInput is a <input type="text"> element
            $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });
        });

        function assignCustomers() {
            $vendor = $('#vendor').val();

            var values = new Array();
            $.each($("input[name='check[]']:checked"), function() {
                var data = $(this).parents('tr:eq(0)');
                values.push({
                    'cus_id': $(data).find('td:eq(0)').text(),
                    'name': $(data).find('td:eq(1)').text(),
                    'phone': $(data).find('td:eq(4)').text()
                });
            });

            console.log(values);

            if (values.length == 0) {
                swal("Oops...", "Please, select customers to assign!", "error");
            } else if ($vendor == null) {
                swal("Oops...", "Please, select vendor!", "error");
            } else {
                $.ajax({
                    type: "GET",
                    url: '<?php echo url('/assignCustomersToVendor'); ?>',
                    data: {
                        'vendorId': $vendor,
                        'selectedList': values
                    },
                    success: function(data) {
                        swal("Success", data, "success");
                        window.location.href = "{{ URL::to('/admin/customers') }}"
                    }
                });
            }
        }
    </script>


@stop

@section('footer')

@stop
