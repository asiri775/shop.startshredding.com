@extends('vendor.includes.master-vendor')

@section('content')
<style>
     @media (max-width: 575.98px) {
        .d-flex {
            flex-direction: column !important;
        }
        .gap-2 > * {
            margin-bottom: 10px;
        }
        .w-100 {
            width: 100% !important;
        }
        .w-sm-auto {
            width: 95% !important;
        }
    }
    @media (min-width: 576px) {
        .d-flex {
            display: flex !important;
        }
        .flex-sm-row {
            flex-direction: row !important;
        }
        .gap-2 > *:not(:last-child) {
            margin-right: 10px;
        }
        .w-sm-auto {
            width: auto !important;
        }
    }
</style>

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
                        <div class="row">
                            <form method="POST" action="{!! action('ServiceAgreementController@storeCondition') !!}" class="form-horizontal" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label for="name" class="col-md-4 control-label">TERM NAME <span class="required">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" id="name" name="name" class="form-control"  required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="col-md-4 control-label">TERM CONDITION <span class="required">*</span></label>
                                        <div class="col-md-8">
                                            <textarea id="title" name="title" class="form-control" rows="8"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category" class="col-md-4 control-label">CATEGORY <span class="required">*</span></label>
                                        <div class="col-md-8">
                                            <select id="category" name="categorie_id" class="form-control" required>
                                                <option value="">Select Category</option>
                                                @foreach($category_list as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="industry" class="col-md-4 control-label">INDUSTRY <span class="required">*</span></label>
                                        <div class="col-md-8">
                                            <select id="industry" name="industry_id" class="form-control" required>
                                                <option value="">Select Industry</option>
                                                @foreach($industry_list as $industry)
                                                    <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-4 d-flex flex-column flex-sm-row align-items-stretch gap-2" style="padding-right:0;">
                                            <button type="submit" class="btn btn-success w-100 w-sm-auto" style="background-color: #0F8937; border: none; font-weight: bold; font-size: large; min-height: 48px;">Create Term</button>
                                            <a href="{!! url('admin/terms_conditions_list') !!}" class="btn btn-warning w-100 w-sm-auto" style="background-color: #FFFF14; border: none; color: #000; font-weight: bold; font-size: large; min-height: 48px; padding: 12px 24px;">Cancel</a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
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
                    // Add toolbar items if needed
                ]
            })
            .then(editor => {
               
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@stop