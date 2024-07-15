@extends('vendor.includes.master-vendor')
@section('title','Service Agreement')
@section('content')
@if(Session::has('message'))
    <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('message') }}
    </div>
@endif
@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('error') }}
    </div>
@endif
<div class="page-title row">
  <div class="col-md-12 ">
      <a class="btn btn-primary btn-right pull-right"
          onclick="printPage( '{{route('vendor.service_agreement.print', ['id' => $order->id])}}' )"
          href="javascript:void(0);"></i> <span class="bold">PRINT</span></a>
      <button id="download-btn"
              class="btn btn-success btn-right pull-right"
              type="button"><i class="fa fa-download"></i> <span class="bold">DOWNLOAD</span>
      </button>
      <a href="{!! url('vendor/service_agreement_email/'.$order->id) !!}" class="btn btn-success btn-right pull-right">EMAIL</a>
  </div>
  <form action="{{route('vendor.complete_sa')}}" method="post">
    {{ csrf_field() }}
    <input name="order_id" id="order_id" value="{{ $order->id }}" hidden>
    <div class="row clearfix mb-1">
      <div class="main-title mt-4 ml-1 col-md-6">
        <h3 class="font-montserrat bold fs-16 bold all-caps no-margin">Client info</h3>
      </div>
    </div>
    <div class="row clearfix mb-1">
      <div class="col-md-3">
        <div class="form-group form-group-default required">
          <label>Company Name (*)</label>
          <input type="text" class="form-control client_info" id="companyName" name="company_name" placeholder="Company Name" value="<?php echo $documents->company_name?>" required>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group form-group-default required">
          <label>Contact Name (*)</label>
          <input type="text" class="form-control client_info" id="contactName" name="contact_name" placeholder="Contact Name" value="<?php echo $documents->contact_name?>" required>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group form-group-default required">
          <label>Phone (*)</label>
          <input id="phone" type="tel" pattern="\d{3}\-\d{3}\-\d{4}" name="phone_number" class="form-control telephone client_info" data-mask="(999)-999-9999" placeholder="(999)-999-9999" value="<?php echo $documents->phone_number?>"  required />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group form-group-default required">
          <label>Email</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo $documents->email?>"  placeholder="joan@lifeforcephysio.com">
        </div>
      </div>
    </div>
    <div class="row clearfix mb-1">
    <br />
      <div class="main-title mt-4 ml-1 col-md-6">
        <h3 class="font-montserrat bold fs-16 bold all-caps no-margin">Billing Address</h3>
      </div>
    </div>
    <div class="row clearfix mb-1">
      <div class="col-md-3">
        <div class="form-group form-group-default required">
          <label>Addresss Line 1 (*)</label>
          <input type="text" class="form-control client_info" id="bill-firstName" name="billing_address_1" placeholder="577" value="<?php echo $documents->billing_address_1?>"  required>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group form-group-default required">
          <label>Addresss Line 2</label>
          <input type="text" class="form-control" id="bill-lastName" name="billing_address_2" value="<?php echo $documents->billing_address_2?>" placeholder="Burnhamthorpe Road">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group form-group-default required">
          <label>City (*)</label>
          <input type="text" class="form-control client_info" id="bill-city" name="billing_city" value="<?php echo $documents->billing_city?>"  placeholder="Toronto" required>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group form-group-default required">
          <label>State/Province/Region</label>
          <input type="text" class="form-control" id="bill-state" name="billing_state" value="<?php echo $documents->billing_state?>"  placeholder="Ontario">
        </div>
      </div>
    </div>
    
    <div class="row clearfix mb-1">
      
      <div class="col-md-4">
        <div class="form-group form-group-default required">
          <label>Postal Code (*)</label>
          <input type="text" class="form-control client_info" id="bill-postal" name="billing_postal_code" value="<?php echo $documents->billing_postal_code?>"  placeholder="M9C 2Y3" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group form-group-default required">
          <label>Phone (*)</label>
          <input type="text" class="form-control" id="bill-phoneNumber" name="billing_phone" value="<?php echo $documents->billing_phone?>"  id="phoneNumber2" value="" placeholder="(999)-999-9999" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group form-group-default required">
        <label>Email</label>
           <input type="email" class="form-control" id="bill-email" name="billing_email" value="<?php echo $documents->billing_email?>"  placeholder="joan@lifeforcephysio.com">
          </div>
      </div>
    </div>
    
    <div class="row clearfix mt-1 pt-2">
      <br />
      <div class="main-title mt-4 ml-1 col-md-6">
        <h3 class="font-montserrat bold fs-16 bold all-caps no-margin">Shipping Address</h3>
      </div>
      <!-- <div class="serv-check justify-content-between d-inline-flex w-100 col-md-6">
        <div class="form-check primary mt-1">
          <input type="checkbox" onclick="checkBox(this)" id="defaultCheck">
          <label for="defaultCheck" class="bold">
            Same as Billing
          </label>
        </div>
      </div> -->
    </div>
    <div class="row clearfix mb-1">
      
      <div class="col-md-4">
        <div class="form-group form-group-default required">
          <label>Addresss Line 1 (*)</label>
          <input type="text" class="form-control client_info" id="shipp-firstName" name="shipping_address_1" value="<?php echo $documents->shipping_address_1?>" placeholder="577" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group form-group-default required">
          <label>Addresss Line 2</label>
          <input type="text" class="form-control" id="shipp-lastName" name="shipping_address_2" value="<?php echo $documents->shipping_address_2?>" placeholder="Burnhamthorpe Road">
        </div>
      </div>
    </div><div class="row">
      <div class="col-md-4">
        <div class="form-group form-group-default required">
          <label>City (*)</label>
          <input type="text" class="form-control client_info" id="shipp-city" name="shipping_city" value="<?php echo $documents->shipping_city?>" placeholder="Toronto" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group form-group-default required">
          <label>State/Province/Region</label>
          <input type="text" class="form-control" id="shipp-state" name="shipping_state" value="<?php echo $documents->shipping_state?>" placeholder="Ontario">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group form-group-default required">
          <label>Postal Code (*)</label>
          <input type="text" class="form-control client_info" id="shipp-postal" name="shipping_postal_code" value="<?php echo $documents->shipping_postal_code?>" placeholder="M9C 2Y3" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group form-group-default required">
          <label>Phone (*)</label>
          <input type="text" class="form-control" id="shipp-phoneNumber" name="shipping_phone" id="phoneNumber3" value="<?php echo $documents->shipping_phone?>" value="" placeholder="(999)-999-9999" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group form-group-default required">
          <label>Email</label>
            <input type="email" class="form-control" id="shipp-email" name="shipping_email" value="<?php echo $documents->shipping_email?>" placeholder="joan@lifeforcephysio.com">
          </div>
      </div>
    </div>
    <!-- <div class="row">
      <button  aria-label="" id="confirm_form" class="btn btn-primary btn-cons from-left pull-right" type="submit">
        <span>Confirm</span>
      </button>
    </div> -->
    
  </form>
</div>
<div class="page-title">
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
          <input type="text" class="form-control" value="{{date('m/d/Y', strtotime($order->booking_date))}}" placeholder="Pick Up Date" id="datepicker-component2" disabled>
        </div>
        <div class="input-group-append ">
          <span class="input-group-text"><i class="pg-icon">calendar</i></span>
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
                <th class="fs-14 font-montserrat text-left bold" width="5%">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php $sub_total=0;?>
              @foreach($order_details as $item)
              <tr>
                <td class="text-center"><?php echo $item->quantity?></td>
                <td class="text-center"><?php echo $item->title?></td>
                <td class="text-center">$<?php echo number_format($item->cost/$item->quantity,2,'.', '') ?></td>
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
                    <img class="makeitcounticon" src="/assets/img/ribon.png"> Make It Count <a id="popover-div"  target="_blank" rel="popover" title="Make It Count"><i class="icon-info1 fs-16 bold color-danger"></i></a> 
                  </div>
                </td>
                <td class="text-left">
                  <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bold">$</span>
                    </div>
                    <input type="number" id="makeitcount" min="0" step="0.01" value="0.75" class="form-control">
                </div>
                </td>
              </tr>
              <tr>
                <td class="text-right bold" colspan="3">
                  Estimated Grand Total
                </td>
                <td class="text-left font-montserrat demo-fs-23 bold fs-sm-18">$<?php echo number_format((float)$sub_total+$hst,2,'.','');?></td>
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
<div class='page-title'>
<div class="row row-same-height">
  <div class="col-md-12">
      <h3 class="font-montserrat">Terms and Conditions</h3>
      <p>This AGREEMENT is entered into between <b>SHREDEX INC.</b>a corporation incorporated under the laws of the Province of Ontario (hereinafter referred to
      as “SHREDEX”, “CONTRACTOR”, “Company”, “Supplier”, “Seller”, “Service Provider”, or “Vendor”), and Life Force Physiotherapy (hereinafter referred to
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
        <p>Unless specified in the Pickup Confirmation document, Quotes are provided with the understanding that your documents/materials will be located
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
    <!-- <div class="row">
      <div class="col-12 mt-3">
        <div class="form-check primary m-t-0 ml-2 text-right">
          <input type="checkbox" value="1" id="checkbox-agree" required>
          <label for="checkbox-agree" class="fs-16 bold font-montserrat">The undersigned hereby agrees to this agreement, on behalf of the
            Client.
          </label>
          <div id="checkbox-agree-valid"></div>
        </div>
      </div>
    </div> -->
  </div>
  <div class="col-md-12">
                        <div class="row clearfix mb-1">
                            <div class="col-md-6">
                                <div class="main-title mt-4">
                                    <h3 class="font-montserrat bold fs-16 bold all-caps no-margin">Card Details</h3>
                                </div>
                                <div>
                                    <label>Card Holder Name : <?php echo $documents->credit_card_name ?></label>
                                </div>
                                <div>
                                    <label>Card Number : <?php echo $documents->credit_card_number ?></label>
                                </div>
                                <div>
                                    <label>Expiry :
                                        <?php echo $documents->credit_card_expire_month ?>/<?php echo $documents->credit_card_expire_year ?></label>
                                </div>
                                <div>
                                    <label>CCV : <?php echo $documents->credit_card_ccv ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="main-title mt-4">
                                    <h3 class="">Digital Signature
                                    </h3>
                                </div>
                                <div class="">
                                    <img src="{{asset('/photos').'/'.$documents->order_id.'.jpg'}}">
                                    <label>Signature : {{$documents->credit_card_name}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
</div>
</div>

<script>
$(document).ready(function(){
  var operation_from = "{{$documents->operation_from}}";
  var operation_to = "{{$documents->operation_to}}";
  $('#operation_from').val(operation_from);
  $('#operation_to').val(operation_to);
  
});
  function printPage(url) {
        if (url) {
            var w = window.open(url, 'print page', 'height=900,width=800');
            if (window.focus) {
                w.focus()
            }
            w.window.print();
            setTimeout(function () {
                w.window.close();
            }, 2000);
            return false;
        }
    }

    $("#download-btn").click(function (e) {
        e.preventDefault();  //stop the browser from following
        window.location.href = '/vendor/service_agreement_download/<?php echo $order->id;?>';
    });
//   function checkBox(){
//   if ($('#defaultCheck').is(':checked')) {
//      $('#shipp-firstName').val($('#bill-firstName').val());
//      $('#shipp-lastName').val($('#bill-lastName').val());
//      $('#shipp-city').val($('#bill-city').val());
//      $('#shipp-state').val($('#bill-state').val());
//      $('#shipp-postal').val($('#bill-postal').val());
//      $('#shipp-phoneNumber').val($('#bill-phoneNumber').val());
//      $('#shipp-email').val($('#bill-email').val());
     
//   } else {
//     $('#shipp-firstName,#shipp-lastName,#shipp-city,#shipp-state,#shipp-postal,#shipp-phoneNumber,#shipp-email').val('');
//   }

// }
</script>
@endsection