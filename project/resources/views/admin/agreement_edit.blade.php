@extends('vendor.includes.master-vendor')

@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main">

                <!-- Page Heading -->
                <div class="go-title">
                    <div class="pull-right">
                        <a href="{!! url('admin/agreement_list') !!}" class="btn btn-default btn-back"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <h3>Edit Service Agreement</h3>
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

                             @if (Session::has('message-error'))
                                <div class="alert alert-error alert-dismissable" style="background-color: rgb(223, 102, 102)">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('message-error') }}
                                </div>
                            @endif


                        </div>
                        <div class="gocover"></div>
                        <div id="response"></div>
                        <form method="POST" action="{!! action('ServiceAgreementController@updateAgreement') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="item form-group">
                                <input type="hidden" name="id" value="{{$agreement->id}}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="required">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12"> <!-- Increased width from 6 to 8 -->
                                    <input  type="text" id="name" class="form-control col-md-7 col-xs-12" name="name" value="{{$agreement->name}}" required="required">
                                    <input type="checkbox" name="is_default" value="{{$agreement->is_default}}" id="is_default_checkbox" {{ $agreement->is_default ? 'checked' : '' }}> <span> Is Default</span>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="content">Main Condition<span class="required">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <textarea id="content" name="content" class="form-control col-md-7 col-xs-12" rows="10" required>{{$agreement->content}}</textarea>
                                </div>
                            </div>


                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Conditions<span class="required">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12"> <!-- Increased width from 6 to 8 -->
                                    @foreach($condition_list_array as $condition)
                                        <div class="checkbox">
                                            <label style="font-weight: bold;">
                                                <input type="checkbox" name="condition_list[]" {{ $condition['is_active'] ? 'checked' : '' }} value="{{$condition['terms_and_condition_id']}}"> {!! strip_tags( $condition['terms_and_condition_name'] ) !!}
                                            </label>
                                        </br>
                                            <p>{!! $condition['terms_and_condition_title'] !!}</p>
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                       
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="add_ads" type="submit" class="btn btn-success btn-block">Update Agreement</button>
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
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script>
        const checkbox = document.getElementById('is_default_checkbox');

        checkbox.addEventListener('change', function () {
            this.value = this.checked ? true : false;
        });

         document.addEventListener('DOMContentLoaded', function() {
            var titleTextarea = document.querySelector('#content');
            if (titleTextarea) {
                ClassicEditor
                    .create(titleTextarea, {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', 'underline', 'strikethrough', '|',
                            'bulletedList', 'numberedList', '|',
                            'blockQuote', 'link', '|',
                            'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                       
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        });

</script>
@stop