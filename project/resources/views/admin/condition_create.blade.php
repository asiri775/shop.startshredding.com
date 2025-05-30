@extends('vendor.includes.master-vendor')

@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main">

                <!-- Page Heading -->
                <div class="go-title">
                    <h3>Master List - Agreement Terms and Conditions (Parts)</h3>
                    <p>
                        <a href="{!! url('admin/terms_conditions_list') !!}" class="btn btn-link" style="padding:0; color:#776a69; font-weight:bold;">List Home</a>
                        / Create Terms
                    </p>
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
                        <div class="gocover"></div>
                        <div id="response"></div>
                        <form method="POST" action="{!! action('ServiceAgreementController@storeCondition') !!}" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="title" class="col-md-3 control-label">Title <span class="required">*</span></label>
                                <div class="col-md-6">
                                    <textarea id="title" name="title" class="form-control" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="category" class="col-md-3 control-label">Category <span class="required">*</span></label>
                                <div class="col-md-6">
                                    <select id="category" name="categorie_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach($category_list as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="industry" class="col-md-3 control-label">Industry <span class="required">*</span></label>
                                <div class="col-md-6">
                                    <select id="industry" name="industry_id" class="form-control" required>
                                        <option value="">Select Industry</option>
                                        @foreach($industry_list as $industry)
                                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3" style="padding-right:0;">
                                    <button type="submit" class="btn btn-success" style="background-color: #0F8937; border: none; float: left; margin-right: 10px;font-weight: bold;">Create Term</button>
                                    <a href="{!! url('admin/terms_conditions_list') !!}" class="btn btn-warning" style="float: left; background-color: #FFFF14;border: none;color: #000;font-weight: bold;">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

@stop

@section('footer')
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#title'), {
            toolbar: [
                
            ]
            })
            .catch(error => {
            console.error(error);
            });
    </script>
@stop