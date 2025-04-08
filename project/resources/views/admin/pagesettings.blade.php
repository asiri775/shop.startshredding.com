@extends('admin.includes.master-admin')
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main">

                <!-- Page Heading -->
                <div class="go-title">
                    <h3>Page Settings</h3>
                    <div class="go-line"></div>
                </div>
                <!-- Page Content -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="res">
                            @if(Session::has('message'))
                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                        </div>
                        <!-- /.start -->
                        <div class="col-md-12">
                            <ul class="nav nav-tabs tabs-left">
                                <li class="active"><a href="#faq" data-toggle="tab" aria-expanded="true">FAQ Page</a>
                                </li>
                                <li><a href="#brands" data-toggle="tab" aria-expanded="false">Brand Logos</a></li>
                                <li><a href="#banners" data-toggle="tab" aria-expanded="false">Home Banners</a></li>
                                <li><a href="#largeBanner" data-toggle="tab" aria-expanded="false">Large Home Banners</a></li>
                                <li><a href="#about" data-toggle="tab" aria-expanded="false">About Us Page</a></li>
                                <li><a href="#contact" data-toggle="tab" aria-expanded="false">Contact Us Page</a></li>
                                 <li><a href="#service" data-toggle="tab" aria-expanded="false">Service Agreement</a></li>
                                
                            </ul>
                        </div>

                        <div class="col-xs-12">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane" id="about">
                                    <p class="lead">About Us Page</p>
                                    <div class="ln_solid"></div>
                                    <form method="POST" action="{{action('PageSettingsController@about')}}" class="form-horizontal form-label-left">
                                        {{csrf_field()}}
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> Disable/Enable About Page <span class="required">*</span>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-9">
                                                @if($pagedata->a_status == 1)
                                                    <input type="checkbox" data-toggle="toggle" data-on="Enabled" name="a_status" value="1" data-off="Disabled" checked>
                                                @else
                                                    <input type="checkbox" data-toggle="toggle" data-on="Enabled" name="a_status" value="1" data-off="Disabled">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> About Us Page Content <span class="required">*</span>
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <textarea rows="10" class="form-control" name="about" id="content1" placeholder="About Page Contents" required="required">{{$pagedata->about}}</textarea>
                                            </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button id="about_page_update" type="submit" class="btn btn-success btn-block">Update About Page</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="contact">
                                    <p class="lead">Contact Page Content</p>
                                    <div class="ln_solid"></div>
                                    <form method="POST" action="{{action('PageSettingsController@contact')}}" class="form-horizontal form-label-left">
                                        {{csrf_field()}}
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> Disable/Enable Contact Page <span class="required">*</span>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-9">
                                                @if($pagedata->c_status == 1)
                                                    <input type="checkbox" data-toggle="toggle" data-on="Enabled" name="c_status" value="1" data-off="Disabled" checked>
                                                @else
                                                    <input type="checkbox" data-toggle="toggle" data-on="Enabled" name="c_status" value="1" data-off="Disabled">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> Contact Form Success Text <span class="required">*</span>
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <textarea rows="3" class="form-control" name="contact" placeholder="Contact Page Content" required="required">{{$pagedata->contact}}</textarea>
                                            </div>

                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> Contact Us Email Address <span class="required">*</span>
                                                <p class="small-label">Separate by Comma(,) for Multiple Email</p>
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <textarea rows="3" class="form-control" name="contact_email" placeholder="Contact Us Email Address" required="required">{{$pagedata->contact_email}}</textarea>
                                            </div>

                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button id="contact_page_update" type="submit" class="btn btn-success btn-block">Update Contact Page</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                               <div class="tab-pane" id="service">
                                    <p class="lead">Service Agreement</p>
                                    <div class="ln_solid"></div>
                                    <form method="POST" action="{{action('PageSettingsController@service')}}" class="form-horizontal form-label-left">
                                        {{csrf_field()}}
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> Client Information <span class="required">*</span>
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                              <textarea rows="4" class="form-control" name="client_information" id="content2" placeholder="Client Information" >{{$pagedata->client_information}}</textarea>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> Terms and Conditions <span class="required">*</span>
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                              <textarea rows="4" class="form-control" name="terms_and_conditions" id="content3" placeholder="Terms and Conditions" >{{$pagedata->terms_and_conditions}}</textarea>
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> Credit Card Infromation <span class="required">*</span>
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                              <textarea rows="4" class="form-control" name="credit_card_infromation" id="content4" placeholder="Credit Card Infromation" >{{$pagedata->credit_card_infromation}}</textarea>
                                            </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button id="terms_and_condition_update" type="submit" class="btn btn-success btn-block">Update Service Agreement</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane active" id="faq">
                                    <div class="pull-right">
                                        <a href="{!! url('admin/faq/add') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New FAQ</a>
                                    </div>
                                    <p class="lead">FAQ Page</p>
                                    <div class="ln_solid"></div>
                                    <form method="POST" action="{{action('PageSettingsController@faq')}}" class="form-horizontal form-label-left">
                                        {{csrf_field()}}
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook"> Disable/Enable FAQ Page <span class="required">*</span>
                                            </label>
                                            <div class="col-md-2 col-sm-3 col-xs-6">
                                                @if($pagedata->f_status == 1)
                                                    <input type="checkbox" data-toggle="toggle" data-on="Enabled" name="f_status" value="1" data-off="Disabled" checked>
                                                @else
                                                    <input type="checkbox" data-toggle="toggle" data-on="Enabled" name="f_status" value="1" data-off="Disabled">
                                                @endif
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <button id="faq_page_update" type="submit" class="btn btn-success">Apply</button>
                                            </div>
                                        </div>

                                    </form>
                                    <p class="lead">All FAQs</p>
                                    <table class="table" id="example">
                                        <thead>
                                        <tr>
                                            <th width="35%">Questions</th>
                                            <th width="45%">Answers</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($faqs as $faq)
                                            <tr>
                                                <td>{{$faq->question}}</td>
                                                <td>{{substr(strip_tags($faq->answer),0,150)}}</td>
                                                <td>
                                                    <a href="faq/{{$faq->id}}/edit" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit </a>
                                                    <a href="faq/{{$faq->id}}/delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="brands">
                                    <div class="pull-right">
                                        <a href="{!! url('admin/brand/add') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Logo</a>
                                    </div>
                                    <p class="lead">Brand Logos</p>
                                    <table class="table" id="example">
                                        <thead>
                                            <tr>
                                                <th width="35%">Brand Logo</th>
                                                <th width="20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($brands as $brand)
                                            <tr>
                                                <td><img src="{{url('assets/images/brands')}}/{{$brand->image}}"></td>
                                                <td>
                                                    {{--<a href="brand/{{$brand->id}}/edit" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit </a>--}}
                                                    <a href="brand/{{$brand->id}}/delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="banners">
                                    <div class="pull-right">
                                        <a href="{!! url('admin/banner/add') !!}" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add New Banner</a>
                                    </div>
                                    <p class="lead">Home Banners</p>
                                    <table class="table" id="example">
                                        <thead>
                                            <tr>
                                                <th width="35%">Banner</th>
                                                <th width="45%">HyperLink</th>
                                                <th width="20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($banners as $banner)
                                            <tr>
                                                <td><img style="max-width: 250px;" src="{{url('assets/images/brands')}}/{{$banner->image}}"></td>
                                                <td>{{$banner->link}}</td>
                                                <td>
                                                    <a href="banner/{{$banner->id}}/edit" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit </a>
                                                    <a href="banner/{{$banner->id}}/delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Remove </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="largeBanner">
                                    <p class="lead">Large Banner</p>
                                    <div class="ln_solid"></div>
                                    <form method="POST" action="banner/large" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Current Large Banner <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <img class="col-md-10" src="../assets/images/{{$pagedata->large_banner}}">
                                            </div>

                                        </div><br>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Setup New Banner <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="file" name="large_banner" />
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Large Banner Link <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input class="form-control col-md-7 col-xs-12" name="banner_link" placeholder="Large Banner Link" required="required" type="text" value="{{$pagedata->banner_link}}">
                                            </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button type="submit" class="btn btn-success btn-block">Update Large Banner</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- /.end -->
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
    <script type="text/javascript">
        // bkLib.onDomLoaded(function() {
        //     new nicEditor({fullPanel : true}).panelInstance('content1');
        // });
        // bkLib.onDomLoaded(function() {
        //     new nicEditor({fullPanel : true}).panelInstance('content2');
        // });
    </script>
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
            ClassicEditor.create( document.querySelector( '#content1' ) )
                .catch( error => {
                    console.error( error );
                } );

             ClassicEditor.create( document.querySelector( '#content2' ) )
                .catch( error => {
                    console.error( error );
                } );

              ClassicEditor.create( document.querySelector( '#content3' ) )
                .catch( error => {
                    console.error( error );
                } );
                
              ClassicEditor.create( document.querySelector( '#content4' ) )
                .catch( error => {
                    console.error( error );
                } );    
        </script>
@stop