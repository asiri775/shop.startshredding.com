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
                        <a href="{!! url('admin/condition/create') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Condition</a>
                    </div>
                    <h3>Master List - Agreement Terms and Conditions (Parts)</h3>
                    <div class="go-line"></div>
                </div>

                <!-- Page Content -->
                <div class="panel panel-default">

                    <div class="panel-body">
                        <form method="post" action="{{ url('/admin/condition/searchResults') }}" id="main-form"
                            class="basic-form horizontal-form col-md-12 col-sm-12 col-xs-12 customer_left_portion">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4">
                                    <label>KEYWORD SEARCH</label>
                                    <div class="input-group">
                                        <input name="search" class="form-control" placeholder="Search for a keyword or name of the Term" autocomplete="off"
                                            type="text" id="search">
                                        <span class="input-group-btn"><label class="btn btn-default search-icon"><i
                                                    class="fa fa-search"></i></label></span>
                                    </div>
                                </div>
                        
                                <div class="col-md-2">
                                    <label>CATEGORY</label>
                                    <div class="form-group">
                                        <select class="form-control chzn-select" name="category" id="category">
                                            <option value="" selected>Category Filter1</option>
                                            @if (!empty($category_list))
                                                @foreach($category_list as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label>INDUSTRY</label>
                                    <div class="form-group">
                                        <select class="form-control chzn-select" name="industry" id="industry">
                                            <option value="" selected>Industry Filter1</option>
                                            @if (!empty($industry_list))
                                                @foreach($industry_list as $industry)
                                                    <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-2">
                                    <label for="status">STATUS</label>
                                    <div class="form-group">
                                        <!-- <label for="client_type">Status:</label> -->
                                        <select class="form-control chzn-select" name="status" id="status">
                                            <option value="" selected>Active/Inactive</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-2">
                                    <label>ID</label>
                                    <div class="input-group">
                                        <input name="id" class="form-control" placeholder="ID#" autocomplete="off"
                                            type="text" id="id">
                                        <span class="input-group-btn"><label class="btn btn-default search-icon"><i
                                                    class="fa fa-search"></i></label></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-12" align="right">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i>
                                        Search</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <hr>

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
                                            <th style="word-break: break-all;">ID</th>
                                            <th style="word-break: break-all;">TERM_NAME</th>
                                            <th style="word-break: break-all;">CATEGORY</th>
                                            <th style="word-break: break-all;">INDUSTRY</th>
                                            <th style="word-break: break-all;">STATUS</th>
                                            <th width="10%">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($condition_list as $condition)
                                            <tr>
                                                <td>{{ $condition->id }}</td>
                                           
                                                <td style="word-break: break-all; white-space: pre-line;">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($condition->title), 50, '...') }}
                                                </td>
                                                <td style="word-break: break-all; white-space: pre-line;">
                                                    {{ $condition->category->name }}
                                                </td>
                                                <td style="word-break: break-all; white-space: pre-line;">
                                                    {{ $condition->industry->name }}
                                                </td>

                                                <td style="word-break: break-all; white-space: pre-line;">
                                                    {{ $condition->status }}
                                                </td>

                                                <td>
                                                    <a href="javascript:;"
                                                        class="btn btn-info btn-xs btn-preview"
                                                        data-id="{{ $condition->id }}"
                                                        data-title="{{ strip_tags($condition->title, '<br>') }}"
                                                        data-category="{{ $condition->category->name }}"
                                                        data-industry="{{ $condition->industry->name }}"
                                                        data-status="{{ $condition->status }}"
                                                        data-content="{{ $condition->content ?? '' }}"
                                                        data-toggle="modal"
                                                        data-target="#preview-modal">
                                                        <i class="fa fa-eye"></i> Preview
                                                    </a>


                                                    <a href="{{ url('/admin/condition/edit') }}/{{ $condition->id }}"
                                                        class="btn btn-primary btn-xs"><i class="fa fa-check"></i>
                                                        Edit Details
                                                    </a>

                                                    <a href="{{ url('/admin/condition/duplicate') }}/{{ $condition->id }}"
                                                        class="btn btn-warning btn-xs"><i class="fa fa-copy"></i>
                                                        Duplicate
                                                    </a>

                                                    <a href="javascript:;"
                                                        class="btn btn-danger btn-xs btn-delete"
                                                        data-href="{{ url('/') }}/admin/condition/destroy/{{ $condition->id }}"
                                                        data-id="{{ $condition->id }}"
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

                   
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->


    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p>You are about to delete this Condition. Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button class="btn btn-danger" id="btn-confirm-delete">Delete</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="preview-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="preview-title">Preview Condition</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 8px;">
                        <div class="col-xs-2 text-right" style="font-weight:bold;">ID:</div>
                        <div class="col-xs-10 text-left"><span id="preview-id"></span></div>
                    </div>
                    <div class="row" style="margin-bottom: 8px;">
                        <div class="col-xs-2 text-right" style="font-weight:bold;">Title:</div>
                        <div class="col-xs-10 text-left"><span id="preview-title-text"></span></div>
                    </div>
                    <div class="row" style="margin-bottom: 8px;">
                        <div class="col-xs-2 text-right" style="font-weight:bold;">Category:</div>
                        <div class="col-xs-10 text-left"><span id="preview-category"></span></div>
                    </div>
                    <div class="row" style="margin-bottom: 8px;">
                        <div class="col-xs-2 text-right" style="font-weight:bold;">Industry:</div>
                        <div class="col-xs-10 text-left"><span id="preview-industry"></span></div>
                    </div>
                    <div class="row" style="margin-bottom: 8px;">
                        <div class="col-xs-2 text-right" style="font-weight:bold;">Status:</div>
                        <div class="col-xs-10 text-left"><span id="preview-status"></span></div>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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
                    swal("Success", "Condition deleted successfully.", "success");
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


        $(document).on('click', '.btn-preview', function () {
            $('#preview-id').text($(this).data('id'));
            $('#preview-title-text').text($(this).data('title'));
            $('#preview-category').text($(this).data('category'));
            $('#preview-industry').text($(this).data('industry'));
            $('#preview-status').text($(this).data('status'));
            $('#preview-content').html($(this).data('content'));
        });

    </script>

@stop

@section('footer')

@stop
