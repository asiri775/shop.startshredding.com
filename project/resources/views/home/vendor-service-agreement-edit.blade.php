<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title>Startshredding | Sercice Agreement</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
<link rel="icon" type="image/png" href="/shop_assets/images/favicon/android-icon-192x192.png" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta content="" name="description" />
<meta content="" name="author" />
<link href="{{ URL::asset('new_assets/assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('new_assets/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"
      type="text/css" />
<link href="{{ URL::asset('new_assets/assets/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet"
      type="text/css" />
<link href="{{ URL::asset('new_assets/assets/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet"
      type="text/css" media="screen" />
<link href="{{ URL::asset('new_assets/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"
      media="screen" />
<link href="{{ URL::asset('new_assets/assets/plugins/switchery/css/switchery.min.css')}}" rel="stylesheet"
      type="text/css" media="screen" />
<link href="{{ URL::asset('new_assets/assets/plugins/nvd3/nv.d3.min.css')}}" rel="stylesheet" type="text/css"
      media="screen" />
<link href="{{ URL::asset('new_assets/assets/plugins/mapplic/css/mapplic.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('new_assets/assets/plugins/rickshaw/rickshaw.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('new_assets/assets/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet"
      type="text/css" media="screen">
<link href="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')}}"
      rel="stylesheet" type="text/css" />
<link
        href="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')}}"
        rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('new_assets/assets/plugins/datatables-responsive/css/datatables.responsive.css')}}"
      rel="stylesheet" type="text/css" media="screen" />
<!-- <link href="{{ URL::asset('new_assets/assets/plugins/jquery-metrojs/MetroJs.css')}}" rel="stylesheet" type="text/css"
      media="screen" /> -->
<link href="{{ URL::asset('new_assets/pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('new_assets/pages/css/pages.css')}}" class="main-stylesheet" rel="stylesheet"
      type="text/css" />

<link href="{{ URL::asset('new_assets/assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('new_assets/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"
      media="screen" />
<link href="{{ URL::asset('/home_assets/images/form-wizard/pages.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/home_assets/images/form-wizard/style.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<style>
    .top-right1 {
        position: absolute !important;
        /* top: 1px; */
        right: 0;
    }

    .font-clr {
        color: #B6B6B6;
    }
    .page-sidebar
    {
        background-color:#000080;
    }
    .table thead {
        background-color:#000080;
    }
    .addcreadit-btn {
        background-color: #000080 !important;
        border-color: #000080 !important;
    }
    .icon-thumbnail {
        background:#ff2800;
    }

    .main-header-center .custom-padding .form-control {
    padding: 0.2rem 1rem;
  }
  .toast-center {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

</style>

<script src="{{ URL::asset('/new_assets/assets/plugins/popper/umd/popper.min.js')}}" type="text/javascript"></script>
</head>

<body class="fixed-header horizontal-menu horizontal-app-menu dashboard">
  <!-- START HEADER -->
  <div class="header">
    <div class="top-bar">
      <div class="container-fluid">
        <div class="header-inner header-md-height">
          <a href="#" class="btn-link toggle-sidebar d-lg-none header-icon sm-p-l-0 btn-icon-link"
            data-toggle="horizontal-menu">
            <i class="pg-icon">menu</i>
          </a>
           <div class="d-inline-flex main-header-center">
            <div class="brand inline align-self-end">
              <img src="/home_assets/images/form-wizard/logo.png" alt="logo" data-src="/home_assets/images/form-wizard/logo.png"
              data-src-retina="/home_assets/images/form-wizard/logo.png" width="194" height="40">
            </div>
            <div class="input-group w-100 p-2 d-lg-inline-block d-none custom-padding"> 
              <input type="text" class="form-control" placeholder="Search here for an Invoice or Job#" style="font-size:12px;"> 
              <div class="input-group-text btn"><i class="fa fa-search" aria-hidden="true"></i></div> 
             </div>
          </div>
          <div class="d-flex align-items-center">
            <!-- <a href="" class="header-icon btn-icon-link mr-3 d-lg-inline-block d-none lh-25">
              <span class="icon-phone1"></span>
              <span>(416) 255-1500</span>
            </a> -->
            <!--a href="" class="header-icon btn-icon-link mr-3 d-lg-inline-block d-none lh-25">
              <span class="icon-mail1"></span>
              <span>info@startshredding.com</span>
            </a-->
            <!-- START User Info-->
            <!-- <div class="pull-left p-r-10 fs-14 font-heading d-lg-inline-block d-none">
              <span class="semi-bold">Smith</span> <span class="">Nest</span>
            </div>
            <div class="dropdown pull-right d-lg-block">
              <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false" aria-label="profile dropdown">
                <span class="thumbnail-wrapper d32 circular inline">
                  <img src="/home_assets/images/form-wizard/avatar.jpg" alt="" data-src="/home_assets/images/form-wizard/avatar.jpg"
                    data-src-retina="/home_assets/images/form-wizard/avatar_small2x.jpg" width="32" height="32">
                </span>
              </button>
              <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                <a href="#" class="dropdown-item"><span class="fs-11">Signed in as</span><br /><span class="fs-14"><b>Smith Aunsberg</b></span></a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">Your Profile</a>
                <a href="#" class="dropdown-item">Change Password</a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">Help</a>
                <a href="#" class="dropdown-item">Logout</a>
              </div>
            </div> -->
            <!-- END User Info-->
          </div>
        </div>
      </div>
    </div>
    <!--End top-bar-->

    <div class="main-menu shadow-sm v-2">
      <div class="container-fluid">
        <div class="menu-bar header-sm-height main-menu-bar" data-pages-init='horizontal-menu' data-hide-extra-li="2">
          <a href="#" class="btn-link header-icon toggle-sidebar d-lg-none right" data-toggle="horizontal-menu">
            <i class="pg-icon">close</i>
          </a>
          <div class="m-search d-flex d-lg-none">
            <a href="#" class="search-link d-lg-none fs-11"
            data-toggle="search"><i class="icon-search1 text-light mr-2"></i>Search Invoice or Job#</a>
             <div class="input-group w-100 p-2"> 
               <input type="text" class="form-control" placeholder="Search Invoice or Job#"> 
               <div class="input-group-text btn"><i class="icon-search1 text-white"></i></div> 
              </div>
            </div>
          <ul>
            <li class=" active">
              <a href="index.html">Dashboard</a>
            </li>
            <li>
              <a href="#"><span class="title">Service History</span></a>
            </li>
            <li>
              <a href="#"><span class="title">Invoices</span></a>
            </li>
            <li>
              <a href="#"><span class="title">Book Service</span></a>
            </li>
            <li>
              <a href="#"><span class="title">Support</span></a>
            </li>
           </ul>
           <!-- <div class="m-ac">
            <h5 class="all-caps fs-15 text-white m-ac-text">Account balance <span class="bold fs-16 m-ac-bg">$31422.51</span></h5>
           </div> -->
        </div>
      </div>
    </div>
    <!--End Main-menu-->
  </div>
  <div class="page-container ">
    <!-- START PAGE CONTENT WRAPPER -->
    <div class="page-content-wrapper ">
      <!-- START PAGE CONTENT -->
      <div class="content sm-gutter">
        <!-- START JUMBOTRON -->
        <div data-pages="parallax">
          <div class="container-fluid">
            <div class="inner">
              <!-- START BREADCRUMB -->
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Service Agreement</li>
              </ol>
            </div>
          </div>
        </div>
        <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class=" container-fluid">

                          
          <div id="rootwizard" class="m-t-10">
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" id="top">
                        <li class="nav-item">
                          <a class="active d-flex align-items-center" data-toggle="tab" href="#tab1" data-target="#tab1" role="tab"><i class="icon-user fs-14 tab-icon"></i> <span>Client information</span></a>
                        </li>
                        <li class="nav-item">
                          <a class="d-flex align-items-center" data-toggle="tab" href="#tab2" data-target="#tab2" role="tab"><i class="icon-file-text1 fs-14 tab-icon"></i> <span>Terms and Conditions</span></a>
                        </li>
                        <li class="nav-item">
                          <a class="d-flex align-items-center" data-toggle="tab" href="#tab3" data-target="#tab3" role="tab"><i class="icon-credit-card1 fs-14 tab-icon"></i> <span>Confirmation</span></a>
                        </li>
                        <!--li class="nav-item">
                          <a class="d-flex align-items-center" data-toggle="tab" href="#tab4" data-target="#tab4" role="tab"><i class="material-icons fs-14 tab-icon">done</i> <span>Summary</span></a>
                        </li-->
                      </ul>
                      <!-- Tab panes -->
                      <div class="tab-content">
                        
                        <div class="tab-pane padding-20 sm-no-padding active slide-left" id="tab1">
                          <div class="row row-same-height">
                            <div class="client-info sm-m-b-3">
                              <div class="pl-4 pr-4 row-same-height">
                                <div class="row sm-p-0">
                                  <div class="main-title mt-4 ml-1">
                                    <h3 class="font-montserrat bold fs-16 bold all-caps no-margin">Client info</h3>
                                  </div>
                                </div>
                                <div class="row clearfix mb-1 sm-p-0 mt-4">
                                    <div class="col-md-6">
                                      <div class="form-group form-group-default required">
                                        <label>Company Name</label>
                                        <input type="text" class="form-control client_info" id="companyName" value="<?php echo $documents->company_name?>" required>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group form-group-default required">
                                        <label>Contact Name</label>
                                        <input type="text" class="form-control client_info" id="contactName" value="<?php echo $documents->contact_name?>" required>
                                       </div>
                                    </div>
                                  </div>  
                                 <div class="row clearfix mb-2">
                                  <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                      <label>Phone</label>
                                      <input id="phone" type="tel" class="form-control telephone client_info" data-mask="(999)-999-9999" value="<?php echo $documents->phone_number?>"  required />
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                      <label>Email</label>
                                      <input type="email" class="form-control" id="email" value="<?php echo $documents->email?>">
                                    </div>
                                  </div>
                                </div>
                               <p class="font-montserrat bold fs-16 bold mt-3 mb-3">Billing Address</p>
                               <div class="row clearfix mb-1">
                                  <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                      <label>Addresss Line 1</label>
                                      <input type="text" class="form-control client_info" onchange="checkBox(this)" id="bill-firstName" name="firstName" value="<?php echo $documents->billing_address_1?>"  required>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                      <label>Addresss Line 2</label>
                                      <input type="text" class="form-control" onchange="checkBox(this)" id="bill-lastName" value="<?php echo $documents->billing_address_2?>" name="lastName">
                                    </div>
                                  </div>
                                </div>
                                <div class="row clearfix mb-1">
                                  <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                      <label>City</label>
                                      <input type="text" class="form-control client_info" onchange="checkBox(this)" id="bill-city" name="city" value="<?php echo $documents->billing_city?>" required>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                      <label>State/Province/Region</label>
                                      <input type="text" class="form-control " onchange="checkBox(this)" id="bill-state" name="state" value="<?php echo $documents->billing_state?>">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                      <label>Postal Code</label>
                                      <input type="text" class="form-control client_info" onchange="checkBox(this)" id="bill-postal" name="postal" value="<?php echo $documents->billing_postal_code?>" required>
                                    </div>
                                  </div>
                                </div>
                              <div class="row clearfix mb-2">
                                <div class="col-md-6">
                                  <div class="form-group form-group-default required">
                                    <label>Phone</label>
                                    <input type="text" class="form-control client_info" id="bill-phoneNumber" onchange="checkBox(this)" name="phoneNumber" value="<?php echo $documents->billing_phone?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group form-group-default">
                                    <label>Email</label>
                                    <input type="email" class="form-control" id="bill-email" onchange="checkBox(this)" name="email" value="<?php echo $documents->billing_email?>" >
                                  </div>
                                </div>
                              </div>
                              <div class="serv-check justify-content-between d-inline-flex w-100">
                                <p class="font-montserrat bold fs-16 bold mt-3 mb-3">Shipping Address</p>
                                <div class="form-check primary mt-1">
                                  <input type="checkbox" onclick="checkBox(this)" id="defaultCheck" checked>
                                  <label for="defaultCheck" class="bold">
                                    Same as Billing
                                  </label>
                                </div>
                              </div>
                                <div class="row clearfix mb-1">
                                  <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                      <label>Addresss Line 1</label>
                                      <input type="text" class="form-control client_info" onchange="checkBox_2(this)" id="shipp-firstName" name="firstName" required>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                      <label>Addresss Line 2</label>
                                      <input type="text" class="form-control" onchange="checkBox_2(this)" id="shipp-lastName" name="lastName">
                                    </div>
                                  </div>
                                </div>
                                <div class="row clearfix mb-1">
                                  <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                      <label>City</label>
                                      <input type="text" class="form-control client_info" onchange="checkBox_2(this)" id="shipp-city" name="city" required>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                      <label>State/Province/Region</label>
                                      <input type="text" class="form-control" onchange="checkBox_2(this)" id="shipp-state" name="state">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                      <label>Postal Code</label>
                                      <input type="text" class="form-control client_info" onchange="checkBox_2(this)" id="shipp-postal" name="postal" required>
                                    </div>
                                  </div>
                                </div>
                              <div class="row clearfix mb-5">
                                <div class="col-md-6">
                                  <div class="form-group form-group-default required">
                                    <label>Phone</label>
                                    <input type="text" class="form-control client_info" onchange="checkBox_2(this)" id="shipp-phoneNumber" name="phoneNumber" value="">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group form-group-default">
                                    <label>Email</label>
                                    <input type="email" class="form-control" onchange="checkBox_2(this)" id="shipp-email" name="email">
                                  </div>
                                </div>
                              </div>
                            </div>
                            </div>
                            <div class="order-div row-same-height">
                              <div class="pl-4 pr-4 row-same-height">
                              <div class="row sm-p-0">
                                <div class="main-title mt-4 ml-1">
                                  <h3 class="font-montserrat bold fs-16 bold all-caps no-margin">Order info</h3>
                                </div>
                              </div>
                              <div class="row mb-3 sm-p-0 mt-4"> 
                                <div class="col-md-6 mb-2">
                                  <!--label>Pick Up Date</label>
                                  <div class="input-group date">
                                    <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                                      <input class="form-control" type="text" readonly />
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                  </div>
                                  </div-->
                                  <h5 class="all-caps fs-14 mt-1 mb-1">Service Date</h5>
                                  <div class="form-group form-group-default input-group col-md-10">
                                    <div class="form-input-group">
                                      <label>Pick Up Date</label>
                                      <input type="text" class="form-control" placeholder="Pick Up Date" value="{{date('m/d/Y', strtotime($order->booking_date))}}"  id="datepicker-component2">
                                    </div>
                                    <div class="input-group-append ">
                                      <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <h5 class="all-caps fs-14 mt-1 mb-1">Hours of operations</h5>
                                  <div class="row">
                                    <div class="col-md-6 mb-2">
                                     <div class="form-group form-group-default input-group col-md-12 time-group">
                                        <div class="form-input-group">
                                          <label>From</label>
                                          <div id="selector">
                                            <select class="form-control input-lg" id="operation_from">
                                              <option>7.00AM</option>
                                              <option>8.00AM</option>
                                              <option>9.00AM</option>
                                              <option>10.00AM</option>
                                              <option>11.00AM</option>
                                              <option>12.00PM</option>
                                              <option>1.00PM</option>
                                              <option>2.00PM</option>
                                              <option>3.00PM</option>
                                              <option>4.00PM</option>
                                              <option>5.00PM</option>
                                              <option>6.00PM</option>
                                              <option>7.00PM</option>
                                           </select>
                                            <i class="icon-clock1"></i>
                                           </div>
                                         </div>
                                      </div>
                                    </div>  
                                    <div class="col-md-6 mb-2">
                                      <div class="form-group form-group-default input-group col-md-12 time-group">
                                        <div class="form-input-group">
                                          <label>To</label>
                                          <div id="selector">
                                            <select class="form-control input-lg" id="operation_to">
                                              <option>7.00AM</option>
                                              <option>8.00AM</option>
                                              <option>9.00AM</option>
                                              <option>10.00AM</option>
                                              <option>11.00AM</option>
                                              <option>12.00PM</option>
                                              <option>1.00PM</option>
                                              <option>2.00PM</option>
                                              <option>3.00PM</option>
                                              <option>4.00PM</option>
                                              <option>5.00PM</option>
                                              <option>6.00PM</option>
                                              <option>7.00PM</option>
                                           </select>
                                            <i class="icon-clock1"></i>
                                           </div>
                                        </div>
                                      </div>
                                    </div>  
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                               <div class="col-lg-12 col-sm-12">
                                  <div class="row sm-p-0">
                                   <div class="table-responsive table-orderinfo">
                                      <table class="table borderless no-margin">
                                        <thead>
                                          <tr>
                                            <th class="fs-14 font-montserrat text-center bold">QTY</th>
                                            <th class="fs-14 font-montserrat text-center bold">Item</th>
                                            <th class="fs-14 font-montserrat text-center bold">Rate</th>
                                            <th class="fs-14 font-montserrat text-left bold" width="20%">Total</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php $sub_total=0;?>
                                          @foreach($order_details as $item)
                                          <tr>
                                            <td class="text-center"><?php echo $item->quantity?></td>
                                            <td class="text-center"><?php echo $item->title?></td>
                                            @if($item->quantity != 0)
                                              <td class="text-center">$<?php echo number_format($item->cost/$item->quantity,2,'.', '') ?></td>
                                            @else 
                                              <td class="text-center">$<?php echo number_format(0.00,2,'.', '') ?></td>
                                            @endif
                                            <td class="text-left">$<?php echo number_format($item->cost,2,'.', '')?></td>
                                          </tr>
                                            <?php $sub_total+=$item->cost; ?>
                                          @endforeach
                                          
                                          <tr>
                                            <td class="text-right" colspan="3">Sub Total</td>
                                            <td class="text-left bold">$<?php echo number_format((float)$sub_total,2,'.', '');?></td>
                                          </tr>
                                          <tr>
                                            <td class="text-center" colspan="2"></td>
                                            <td class="text-right">HST(13%)</td>
                                            <?php $hst = $sub_total*0.13;?>
                                            <td class="text-left">$<?php echo number_format((float)$hst,2,'.','');?></td>
                                          </tr>
                                          <tr>
                                            <td class="text-center" colspan="3">
                                              <div class="popdiv text-right">
                                                <a href="http://www.janeen.ca"
                                                  id="popover-div" target="_blank" rel="popover"
                                                  title="Make It Count"><img class="makeitcounticon"
                                                  src="{{asset('/assets/img/ribon.png')}}"><span style="color:black;">Make It Count <i
                                                      class="icon-info1 fs-16 bold color-danger"></i></span></a>
                                              </div>
                                            </td>
                                            <td class="text-left">
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bold">$</span>
                                                </div>
                                                <input type="number" min="0" step="0.01" value="{{number_format((float)$order->make_it_count, 2, '.', '')}}" id="makeitcount" class="form-control">
                                            </div>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td class="text-right bold" colspan="3">
                                              Estimated Grand Total
                                            </td>
                                            <td class="text-left font-montserrat demo-fs-23 bold fs-sm-18" id="grand_total">$<?php echo number_format((float)$sub_total+$hst+$order->make_it_count,2,'.','');?></td>
                                          </tr>
                                        </tbody>
                                     </table>
                                    </div>
                                    <p class="fs-14 mt-5">The Grand Total and Line amounts displayed are estimates based on the quantity displayed. The final amount for invoicing and payment may change
                                      depending on the final quantity of materials received and if there are any applicable surcharges as outlined in the Terms and Conditions of this agreement.</p>
                                    </div> 
                                   </div>  
                              </div>
                            </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane padding-20 sm-no-padding" id="tab2">
                          <div class="row row-same-height">
                           <div class="col-md-12">
                               <h3 class="font-montserrat">Terms and Conditions</h3>
                               <textarea id="terms_conditions">
                                @if($order->sa_document=="")
                               <p>This AGREEMENT is entered into between <b>SHREDEX INC.</b>a corporation incorporated under the laws of the Province of Ontario (hereinafter referred to
                                as “SHREDEX”, “CONTRACTOR”, “Company”, “Supplier”, “Seller”, “Service Provider”, or “Vendor”), and {{$documents->company_name}} (hereinafter referred to
                                as the “Client” or “Customer”). The laws of the Province of Ontario shall control this Agreement and any documents to which it is appended.</p>
                             <ol>
                               <li><span class="font-montserrat bold">Scheduling</span>
                                 <p>In order to reduce costs to our clients, our routes are scheduled for maximum efficiency. We will make every attempt to provide service to you at a
                                  time that is most convenient, however we can only guarantee that service will be done between our operating hours of 8am to 5pm, unless certain
                                  times are specifically requested. You may contact our dispatch office on the day of your pick up to request a narrower time window, for your
                                  convenience. If additional material is presented to us upon our arrival at your facility, we will do our best to complete the entire job on the same
                                  day. However, if our prior commitments to other clients prevent us from completing the job, we will re-schedule a pickup of your additional items on
                                  another day. Please note that this will result in additional costs for travel and shredding time.</p>
                               </li>
                               <li><span class="font-montserrat bold">Definition of File Boxes</span>
                                 <p>When rates are provided based on a per ‘file box’ basis, we refer to boxes that measure 15”D x 10”W x 12” H. If your boxes are not the same
                                  dimension, you will be notified by our driver if there will be changes to your rates, depending on the size of the boxes.</p>
                               </li>
                               <li><span class="font-montserrat bold">Location of Documents</span>
                                 <p>Unless specified in the Service Agreement document, Quotes are provided with the understanding that your documents/materials will be located
                                  in an area that will be readily accessible to our employees upon arrival. Materials should be at ground floor level, no greater than 30 feet from the
                                  doorway access, or loading dock area. If documents are not within these parameters, our staff will inform you immediately if any additional charges
                                  will occur, prior to commencing service. A Labour Charge of $2.00 per box will be applied for every 10 steps either up or down, if boxes need to be
                                  manually moved to ground level.</p>
                               </li>
                               <li><span class="font-montserrat bold">Quoted Rates</span>
                                 <p>We offer competitive pricing based on volume, scheduled date of pickup, and the type of service required. If there is a change in the parameters of
                                  the service you requested (ie. Change in quantity of material, or additional labour required to collect materials), you will be notified by our Customer
                                  Service Representative prior to commencement of the job. Changes in your service may result in higher or lower pricing than your quoted rate.
                                  </p>
                               </li>
                               <li><span class="font-montserrat bold">Payment Terms</span>
                                 <p>Our payment terms for non-contract clients are COD. We accept Visa and Mastercard, as well as a company or personal cheque. Cash payments
                                  are accepted, but please note that our drivers cannot make change, therefore exact payment will be required. A $25.00 NSF Fee will apply for
                                  Credit Card Payments that are declined. A $50.00 NSF Fee is applicable for cheque payments that are returned for insufficient funds. In addition,
                                  the Client shall be liable for the <b>shredEX</b>'s expenses for the collection of any unpaid debt including but not limited to termination fees, interest
                                  expenses, court filing fees and legal costs.</p>
                               </li>
                               <li><span class="font-montserrat bold">Cancellation Fee</span>
                                 <p>A Cancellation Fee of $125.00 or 50% of the service order value (whichever is greater) will apply for any service cancelled with less than 24 hours
                                  notice. For Mobile Shredding Service the Cancellation Fee of $250.00 or 100% of the Service Order Value, applies if the service is cancelled with
                                  less than 72 hours notice.</p>
                               </li>
                               <li><span class="font-montserrat bold">Parking Tickets</span>
                                 <p><b>shredEX</b> will make every effort to legally park for the duration of the service. However, the Client agrees to pay for any parking tickets incurred by
                                 <b>shredEX</b> while providing service to the Client, plus a $25.00 administration fee.</p>
                               </li>
                               <li><span class="font-montserrat bold">Payments and Invoices</span>
                                 <p>The Client agrees to pay <b>shredEX</b> for all services rendered. If the Client is delinquent in payment of fees or any other charges due under this
                                  agreement for more than thirty one (31) days, the Client agrees to pay and administration of $7.50 per month per overdue invoice or calculated as
                                  an interest at the rate of 28% per annum, whichever is greater. This fee is continually applied monthly until the balance is paid in full. A $25.00 NSF
                                  Fee will apply for Credit Card or Electronic Fund Transfer Payments that are declined. A $50.00 NSF Fee is applicable for cheque payments that
                                  are returned for insufficient funds.</p>
                                  <p class="bold">If you have any questions regarding this Agreement, please contact your Account Manager at 416-255-1500 or send an email to <a href="mailto:info@shredex.ca">info@shredex.ca</a>
                                  </p>
                               </li>
                             </ol>
                             @else 
                             {{$order->sa_document}}
                             @endif
                              </textarea>
                               
                             <div class="row" hidden>
                              <div class="col-12 mt-3">
                                <div class="form-check primary m-t-0 ml-2 text-right">
                                  <input type="checkbox" value="1" id="checkbox-agree" checked required>
                                  <label for="checkbox-agree" class="fs-16 bold font-montserrat">The undersigned hereby agrees to this agreement, on behalf of the
                                    Client.
                                  </label>
                                  <div id="checkbox-agree-valid"></div>
                                </div>
                              </div>
                             </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane slide-left padding-20 sm-no-padding" id="tab3">
                            <div class="row column-seperation">
                                <div class="col-lg-12">
                                  <h3>Did you confirm all data for this order?</h3> 
                                </div>
                            </div>
                        </div>
                         <!--div class="tab-pane slide-left padding-20 sm-no-padding" id="tab4">
                          <h1>Thank you.</h1>
                          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus et bibendum diam. Nunc facilisis nibh vitae sagittis luctus. Suspendisse aliquet purus nec vestibulum molestie. Maecenas sollicitudin efficitur ornare. Maecenas odio leo, lobortis eget libero id, dictum tincidunt libero.</p>
                         </div-->
                        <div class="padding-20 sm-padding-5 sm-m-b-20 sm-m-t-20 bg-white clearfix">
                          <ul class="pager wizard no-style">
                            <li class="next">
                              <button aria-label="" class="btn btn-primary btn-cons from-left pull-right" type="button">
                                <span><a href="#top">Next</a></span>
                              </button>
                            </li>
                            <li class="next finish hidden">
                            <form id="myForm" action="{{route('vendor.complete_sa')}}" method="POST">
                              {{ csrf_field() }}
                                <input name="company_name" id="form_companyName" hidden>
                                <input name="contact_name" id="form_contactName" hidden>
                                <input name="phone_number" id="form_phone" hidden>
                                <input name="billing_address_1" id="form_bill-firstName" hidden>
                                <input name="billing_address_2" id="form_bill-lastName" hidden>
                                <input name="billing_city" id="form_bill-city" hidden>
                                <input name="billing_state" id="form_bill-state" hidden>
                                <input name="billing_postal_code" id="form_bill-postal" hidden>
                                <input name="email" id="form_email" hidden>
                                <input name="billing_phone" id="form_bill-phoneNumber" hidden>
                                <input name="billing_email" id="form_bill-email" hidden>
                                <input name="shipp_address_1" id="form_shipp-firstName" hidden>
                                <input name="shipp_address_2" id="form_shipp-lastName" hidden>
                                <input name="shipping_city" id="form_shipp-city" hidden>
                                <input name="shipping_state" id="form_shipp-state" hidden>
                                <input name="shipping_postal_code" id="form_shipp-postal" hidden>
                                <input name="shipping_phone" id="form_shipp-phoneNumber" hidden>
                                <input name="shipping_email" id="form_shipp-email" hidden>
                                <input name="operation_from" id="form_operation_from" hidden>
                                <input name="operation_to" id="form_operation_to" hidden>
                                <input name="make_it_count" id="form_makeitcount" hidden>
                                <input name="terms_accepted" id="form_terms_accepted" hidden>
                                <input name="booking_date" id="form_booking_date" hidden>
                                <textarea name="sa_document" id="sa_document" hidden></textarea>
                                <input name="order_id" id="order_id" value="{{ $order->id }}" hidden>
                                <button aria-label="" id="confirm_form" class="btn btn-primary btn-cons from-left pull-right" type="submit">
                                  <span>Confirm</span>
                                </button>
                              </form>
                              <input name="save_flag" id="save_flag" hidden>
                              <input name="csrf" id="csrf" value="{{ csrf_token() }}" hidden>
                            </li>
                            <li class="previous first hidden">
                              <button aria-label="" class="btn btn-default btn-cons from-left pull-right" type="button">
                                <span>First</span>
                                </button>
                            </li>
                            <li class="previous">
                              <button aria-label="" class="btn btn-default btn-cons from-left pull-right" type="button">
                                <span><a href="#top">Previous</a></span>
                              </button>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
  
          </div>
          <!-- END CONTAINER FLUID -->
      </div>    
      <!-- END Page Content -->

      <!-- START COPYRIGHT -->
      <!-- START CONTAINER FLUID -->
      <div class="container-fluid  container-fixed-lg footer">
        <div class="copyright sm-text-center text-center">
          <p class="small-text text-black m-0">
            Copyright © 2022 <b>StartShredding Inc.</b> <br/> All Rights Reserved.
          </p>
          <div class="clearfix"></div>
        </div>
      </div>
   </div>
    <!-- END PAGE CONTENT WRAPPER -->
  </div>
  <!-- END PAGE CONTAINER -->

  <!-- BEGIN VENDOR JS -->
<script src="{{ URL::asset('new_assets/assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/modernizr.custom.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/popper/umd/popper.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript">
</script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery/jquery-easy.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery-unveil/jquery.unveil.min.js')}}" type="text/javascript">
</script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery-ios-list/jquery.ioslist.min.js')}}" type="text/javascript">
</script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery-actual/jquery.actual.min.js')}}"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/select2/js/select2.full.min.js')}}" type="text/javascript" src="">
</script>
<script src="{{ URL::asset('new_assets/assets/plugins/classie/classie.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/switchery/js/switchery.min.js')}}" type="text/javascript">
</script>
<script src="{{ URL::asset('new_assets/assets/plugins/nvd3/lib/d3.v3.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/nvd3/nv.d3.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/nvd3/src/utils.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/nvd3/src/tooltip.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/nvd3/src/interactiveLayer.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/nvd3/src/models/axis.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/nvd3/src/models/line.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/nvd3/src/models/lineWithFocusChart.js')}}" type="text/javascript">
</script>
<script src="{{ URL::asset('new_assets/assets/plugins/mapplic/js/hammer.min.js')}}"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/mapplic/js/jquery.mousewheel.js')}}"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/mapplic/js/mapplic.js')}}"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/rickshaw/rickshaw.min.js')}}"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery-metrojs/MetroJs.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery-inputmask/jquery.inputmask.min.js')}}" type="text/javascript"></script>
<!-- <script src="{{ URL::asset('new_assets/assets/plugins/jquery-metrojs/MetroJs.min.js')}}" type="text/javascript"></script> -->


<script src="{{ URL::asset('new_assets/assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"
        type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/skycons/skycons.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"
        type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js')}}"
        type="text/javascript"></script>
<script
        src="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js')}}"
        type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js')}}"
        type="text/javascript"></script>
<script
        src="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js')}}"
        type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/datatables-responsive/js/datatables.responsive.js')}}"
        type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/plugins/bootstrap-form-wizard/js/jquery.bootstrap.wizard.min.js')}}"
        type="text/javascript"></script>
<script src="{{ URL::asset('new_assets/assets/js/form_wizard.js')}}"
        type="text/javascript"></script>      
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
            
<!-- END VENDOR JS -->
<!-- BEGIN CORE TEMPLATE JS -->
<!-- BEGIN CORE TEMPLATE JS -->
<script src="{{ URL::asset('new_assets/pages/js/pages.js')}}"></script>
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<!-- END PAGE LEVEL JS -->
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<!-- <script src="assets/js/dashboard.js" type="text/javascript"></script> -->
<script src="{{ URL::asset('new_assets/assets/js/scripts.js')}}" type="text/javascript"></script>
<script>
  
    $(document).ready(function(){
      $('#operation_from').val("{{$documents->operation_from}}");
      $('#operation_to').val("{{$documents->operation_to}}");
      if ($('#defaultCheck').is(':checked')) {
          $('#shipp-firstName').val($('#bill-firstName').val());
          $('#shipp-lastName').val($('#bill-lastName').val());
          $('#shipp-city').val($('#bill-city').val());
          $('#shipp-state').val($('#bill-state').val());
          $('#shipp-postal').val($('#bill-postal').val());
          $('#shipp-phoneNumber').val($('#bill-phoneNumber').val());
          $('#shipp-email').val($('#bill-email').val());
          
        } else {
          $('#shipp-firstName,#shipp-lastName,#shipp-city,#shipp-state,#shipp-postal,#shipp-phoneNumber,#shipp-email').val('');
        }
    

      $('#datepicker-component2').datepicker();
        $(document).click(function() {
            $('#here').hide();
        });

        let editor;
        ClassicEditor
          .create( document.querySelector( '#terms_conditions' ) )
          .then( newEditor => {
              editor = newEditor;
          } )
          .catch( error => {
              console.error( error );
          } );
          var total_grand = '{{$sub_total+$hst}}';
        $('#makeitcount').on('keyup', function(){
                  
          var makeitcount = parseFloat($('#makeitcount').val());
          if($('#makeitcount').val()=="") makeitcount = 0.00;
          $('#grand_total').text('$'+ (parseFloat(total_grand)+makeitcount).toFixed(2));
        });

function validate_form() {
          // Perform your validation here
          var val_flag = true;
          var client_info = $('.client_info');
            for(var i = 0; i < client_info.length; i++){
                if(client_info[i].value == "" || client_info[i].value == undefined){
                    val_flag = false;
                    break;
                }
            }
          // Return true if validation passes, otherwise return false
          return val_flag;
      }

document.getElementById("myForm").addEventListener("submit", function(event) {
            // Call the validate function
            
            // If validation fails, prevent form submission
            event.preventDefault();
            var val_flag = validate_form();
            
              $('#form_companyName').val($('#companyName').val());
                $('#form_contactName').val($('#contactName').val());
                $('#form_phone').val($('#phone').val());
                $('#form_bill-firstName').val($('#bill-firstName').val());
                $('#form_bill-city').val($('#bill-city').val());
                $('#form_bill-state').val($('#bill-state').val());
                $('#form_bill-postal').val($('#bill-postal').val());
                $('#form_email').val($('#email').val());
                $('#form_bill-lastName').val($('#bill-lastName').val());
                $('#form_bill-phoneNumber').val($('#bill-phoneNumber').val());
                $('#form_bill-email').val($('#bill-email').val());
                $('#form_shipp-firstName').val($('#shipp-firstName').val());
                $('#form_shipp-lastName').val($('#shipp-lastName').val());
                $('#form_shipp-city').val($('#shipp-city').val());
                $('#form_shipp-state').val($('#shipp-state').val());
                $('#form_shipp-postal').val($('#shipp-postal').val());
                $('#form_shipp-phoneNumber').val($('#shipp-phoneNumber').val());
                $('#form_shipp-email').val($('#shipp-email').val());
                $('#form_operation_from').val($('#operation_from').val());
                $('#form_operation_to').val($('#operation_to').val());
                $('#form_makeitcount').val($('#makeitcount').val());
                $('#form_terms_accepted').val("1");
                $('#form_booking_date').val($('#datepicker-component2').val());
                $('#sa_document').val(editor.getData());

                // console.log($('#sa_document').val());
                this.submit();
        });
    
      var iframe = document.getElementById('myFrame');

      // Access the contentDocument of the iframe
      var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;

      // Access the element inside the iframe by its ID
      var client_name = iframeDocument.getElementById('client_name');
      console.log(client_name);
      

  

  $('.tree [data-toggle="popover"  ]').popover({
      html: true,
      content: function () {
          return $(this).prev().html();
      }
  });

  $('#popover-div').popover({
      html: true,
      trigger: 'hover',
      container: '#popover-div',
      placement: 'bottom',
      content: function () {
          return '<div class="popbox">Help Us Make A Difference!<br>Your small micro donation will go towards providing free services and programs for Mental Health.  In addition, this Merchant will also generously match your donation. <br> <br> <a href="https://dryclean.io/makeitcount.php" title="test add link">Click Here </a> to learn more about this program and the Janeen Foundation</div>';
      }
  });

});
function checkBox(){
    if ($('#defaultCheck').is(':checked')) {
      $('#shipp-firstName').val($('#bill-firstName').val());
      $('#shipp-lastName').val($('#bill-lastName').val());
      $('#shipp-city').val($('#bill-city').val());
      $('#shipp-state').val($('#bill-state').val());
      $('#shipp-postal').val($('#bill-postal').val());
      $('#shipp-phoneNumber').val($('#bill-phoneNumber').val());
      $('#shipp-email').val($('#bill-email').val());
      
    } else {
      $('#shipp-firstName,#shipp-lastName,#shipp-city,#shipp-state,#shipp-postal,#shipp-phoneNumber,#shipp-email').val('');
    }

  }
  function checkBox_2(){
  if(document.getElementById('defaultCheck').checked == true){
    document.getElementById('defaultCheck').checked = false;
  }
}
</script>
<script type="text/javascript">
    $('#phone').inputmask("(999) 999-9999");
    $('#bill-phoneNumber').inputmask("(999) 999-9999");
    $('#shipp-phoneNumber').inputmask("(999) 999-9999");
</script>
  <!-- END PAGE LEVEL JS -->

</body>

</html>