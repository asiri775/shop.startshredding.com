@extends('vendor.includes.master-vendor')

@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main">

                <!-- Page Heading -->
                <div class="go-title">
                    <div class="pull-right">
                        <a href="{!! url('admin/terms_conditions_list') !!}" class="btn btn-default btn-back"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <h3>Edit Condition</h3>
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
                        <form method="POST" action="{!! action('ServiceAgreementController@updateCondition') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="item form-group">
                                <input type="hidden" name="id" value="{{ $condition->id }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Title<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="title" name="title" class="form-control" rows="4">{{ $condition->title }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="category" class="col-md-3 control-label">Category <span class="required">*</span></label>
                                <div class="col-md-6">
                                    <select id="category" name="categorie_id" class="form-control select2" required>
                                        <option value="">Select Category</option>
                                        @foreach($category_list as $category)
                                            <option value="{{ $category->id }}" {{ $condition->categorie_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="industry" class="col-md-3 control-label">Industry <span class="required">*</span></label>
                                <div class="col-md-6">
                                    <select id="industry" name="industry_id" class="form-control select2" required>
                                        <option value="">Select Industry</option>
                                        @foreach($industry_list as $industry)
                                            <option value="{{ $industry->id }}" {{ $condition->industry_id == $industry->id ? 'selected' : '' }}>
                                                {{ $industry->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-md-3 control-label">Status <span class="required">*</span></label>
                                <div class="col-md-6">
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="active" {{ $condition->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $condition->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div>
                                <div class="col-md-6 col-md-offset-3 " style="margin-top: 12px">
                                    <button id="add_ads" type="submit" class="btn btn-success btn-block">Update Condition</button>
                                </div>
                            </div>
                        </form>

                        @push('styles')
                        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                        @endpush

                        @push('scripts')
                        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                $('.select2').select2({
                                    width: '100%'
                                });
                            });
                        </script>
                        @endpush
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('footer')
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script>
       ClassicEditor
            .create(document.querySelector('#title'))
            .catch(error => {
                console.error(error);
            });
    </script>
@stop