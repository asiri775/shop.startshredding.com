<script type="text/javascript" language="javascript">
    window.print();
    window.document.close();
    setTimeout(function () {
        window.close();
    }, 1000);
</script>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Startshredding | Shop</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="shop_assets/images/favicon/android-icon-192x192.png" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="{{ URL::asset('new_assets/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')}}"
        rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- <div class="content "> -->
        <div class="page-content-wrapper">
            <!-- START card -->
            <!-- <div class="card card-default pt-3"> -->
                    <div class="col-md-12">
                        <div class="row clearfix mb-1">
                            <div class="main-title mt-4 ml-1 col-md-6">
                                <h3 class="font-montserrat bold fs-16 bold all-caps no-margin">Client info</h3>
                            </div>
                        </div>
                        <div class="row col-md-12 clearfix mb-1">
                            <div class="col-md-3">
                                <label>Company Name : <?php echo $documents->company_name ?></label>
                            </div>
                            <div class="col-md-3">
                                <label>Contact Name : <?php echo $documents->contact_name ?></label>
                            </div>
                            <div class="col-md-3">
                                <label>Phone : <?php echo $documents->phone_number ?></label>
                            </div>
                            <div class="col-md-3">
                                <label>Email : <?php echo $documents->email ?></label>
                            </div>
                        </div>
                        <div class="row clearfix mb-1">
                            <div class="col-md-6">
                                <div class="main-title mt-4">
                                    <h3 class="font-montserrat bold fs-16 bold all-caps no-margin">Billing Address</h3>
                                </div>
                                <div>
                                    <label>Addresss Line 1 : <?php echo $documents->billing_address_1 ?></label>
                                </div>
                                <div>
                                    <label>Addresss Line 2 : <?php echo $documents->billing_address_2 ?></label>
                                </div>
                                <div>
                                    <label>City : <?php echo $documents->billing_city ?></label>
                                </div>
                                <div>
                                    <label>State/Province/Region : <?php echo $documents->billing_state ?></label>
                                </div>
                                <div>
                                    <label>Postal Code : <?php echo $documents->billing_postal_code ?></label>
                                </div>
                                <div>
                                    <label>Phone : <?php echo $documents->billing_phone ?></label>
                                </div>
                                <div>
                                    <label>Email : <?php echo $documents->billing_email ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="main-title mt-4">
                                    <h3 class="font-montserrat bold fs-16 bold all-caps no-margin">Shipping Address</h3>
                                    <div>
                                        <label>Addresss Line 1 : <?php echo $documents->shipping_address_1 ?></label>
                                    </div>
                                    <div>
                                        <label>Addresss Line 2 : <?php echo $documents->shipping_address_2 ?></label>
                                    </div>
                                    <div>
                                        <label>City : <?php echo $documents->shipping_city ?></label>
                                    </div>
                                    <div>
                                        <label>State/Province/Region : <?php echo $documents->shipping_state ?></label>
                                    </div>
                                    <div>
                                        <label>Postal Code : <?php echo $documents->shipping_postal_code ?></label>
                                    </div>
                                    <div>
                                        <label>Phone : <?php echo $documents->shippig_phone ?></label>
                                    </div>
                                    <div>
                                        <label>Email : <?php echo $documents->shippig_email ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="main-title mt-4 ml-1 col-md-6">
                                <h3 class="font-montserrat bold fs-16 bold all-caps no-margin">Order info</h3>
                            </div>
                        </div>
                        <div class="row mb-3 mt-4">
                            <div class="col-md-6 mb-2">
                                <h5 class="all-caps fs-14 mt-1 mb-1"><strong>Service Date</strong></h5>

                                <label>Pick Up Date : {{date('m/d/Y', strtotime($order->booking_date))}}</label>
                            </div>
                            <div class="col-md-6">
                                <h5 class="all-caps fs-14 mt-1 mb-1"><strong>Hours of operations</strong></h5>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label>From : {{$documents->operation_from}}</label>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label>To : {{$documents->operation_to}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-12 col-sm-12">
                                <div class="table-responsive table-orderinfo">
                                    <table class="table borderless no-margin">
                                        <thead>
                                            <tr>
                                                <th class="fs-14 font-montserrat text-center bold">QTY</th>
                                                <th class="fs-14 font-montserrat text-center bold">Item</th>
                                                <th class="fs-14 font-montserrat text-center bold">Rate</th>
                                                <th class="fs-14 font-montserrat text-left bold" width="15%">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $sub_total = 0;?>
                                            @foreach($order_details as $item)
                                            <tr>
                                                <td class="text-center"><?php echo $item->quantity ?></td>
                                                <td class="text-center"><?php echo $item->title ?></td>
                                                <td class="text-center">
                                                    $<?php echo number_format($item->cost / $item->quantity, 2, '.', '') ?>
                                                </td>
                                                <td class="text-left">
                                                    $<?php echo number_format($item->cost, 2, '.', '') ?>
                                                </td>
                                            </tr>
                                            <?php $sub_total += $item->cost;?>
                                            @endforeach

                                            <tr>
                                                <td class="text-right" colspan="3">Sub Total</td>
                                                <td class="text-left bold">
                                                    $<?php echo number_format((float) $sub_total, 2, '.', ''); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="2"></td>
                                                <td class="text-right">HST(13%)</td>
                                                <?php $hst = $sub_total * 0.13;?>
                                                <td class="text-left">
                                                    $<?php echo number_format((float) $hst, 2, '.', ''); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="3">
                                                    <div class="popdiv text-right">
                                                        <img class="makeitcounticon"
                                                            src="{{asset('/assets/img/ribon.png')}}"> Make It Count <a
                                                            id="popover-div" target="_blank" rel="popover"
                                                            title="Make It Count"><i
                                                                class="icon-info1 fs-16 bold color-danger"></i></a>
                                                    </div>
                                                </td>
                                                <td class="text-left">
                                                    
                                                    <label><span class=" bold">$</span>{{$documents->make_it_count}}</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right bold" colspan="3">
                                                    Estimated Grand Total
                                                </td>
                                                <td class="text-left font-montserrat demo-fs-23 bold fs-sm-18">
                                                    $<?php echo number_format((float) $sub_total + $hst, 2, '.', ''); ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="fs-14 mt-5">The Grand Total and Line amounts displayed are estimates based on
                                    the
                                    quantity displayed. The final amount for invoicing and payment may change
                                    depending on the final quantity of materials received and if there are any
                                    applicable
                                    surcharges as outlined in the Terms and Conditions of this agreement.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <!-- <div class="col-md-10"> -->
                                <h3 class="font-montserrat">Terms and Conditions</h3>
                                <p>This AGREEMENT is entered into between <b>SHREDEX INC.</b>a corporation incorporated
                                    under the laws of the Province of Ontario (hereinafter referred to
                                    as “SHREDEX”, “CONTRACTOR”, “Company”, “Supplier”, “Seller”, “Service Provider”, or
                                    “Vendor”), and Life Force Physiotherapy (hereinafter referred to
                                    as the “Client” or “Customer”). The laws of the Province of Ontario shall control
                                    this
                                    Agreement and any documents to which it is appended.</p>
                                <ol>
                                    <li><span class="font-montserrat bold">Scheduling</span>
                                        <p>In order to reduce costs to our clients, our routes are scheduled for maximum
                                            efficiency. We will make every attempt to provide service to you at a
                                            time that is most convenient, however we can only guarantee that service
                                            will be
                                            done between our operating hours of 8am to 5pm, unless certain
                                            times are specifically requested. You may contact our dispatch office on the
                                            day
                                            of your pick up to request a narrower time window, for your
                                            convenience. If additional material is presented to us upon our arrival at
                                            your
                                            facility, we will do our best to complete the entire job on the same
                                            day. However, if our prior commitments to other clients prevent us from
                                            completing the job, we will re-schedule a pickup of your additional items on
                                            another day. Please note that this will result in additional costs for
                                            travel
                                            and shredding time.</p>
                                    </li>
                                    <li><span class="font-montserrat bold">Definition of File Boxes</span>
                                        <p>When rates are provided based on a per ‘file box’ basis, we refer to boxes
                                            that
                                            measure 15”D x 10”W x 12” H. If your boxes are not the same
                                            dimension, you will be notified by our driver if there will be changes to
                                            your
                                            rates, depending on the size of the boxes.</p>
                                    </li>
                                    <li><span class="font-montserrat bold">Location of Documents</span>
                                        <p>Unless specified in the Pickup Confirmation document, Quotes are provided
                                            with
                                            the understanding that your documents/materials will be located
                                            in an area that will be readily accessible to our employees upon arrival.
                                            Materials should be at ground floor level, no greater than 30 feet from the
                                            doorway access, or loading dock area. If documents are not within these
                                            parameters, our staff will inform you immediately if any additional charges
                                            will occur, prior to commencing service. A Labour Charge of $2.00 per box
                                            will
                                            be applied for every 10 steps either up or down, if boxes need to be
                                            manually moved to ground level.</p>
                                    </li>
                                    <li><span class="font-montserrat bold">Quoted Rates</span>
                                        <p>We offer competitive pricing based on volume, scheduled date of pickup, and
                                            the
                                            type of service required. If there is a change in the parameters of
                                            the service you requested (ie. Change in quantity of material, or additional
                                            labour required to collect materials), you will be notified by our Customer
                                            Service Representative prior to commencement of the job. Changes in your
                                            service
                                            may result in higher or lower pricing than your quoted rate.
                                        </p>
                                    </li>
                                    <li><span class="font-montserrat bold">Payment Terms</span>
                                        <p>Our payment terms for non-contract clients are COD. We accept Visa and
                                            Mastercard, as well as a company or personal cheque. Cash payments
                                            are accepted, but please note that our drivers cannot make change, therefore
                                            exact payment will be required. A $25.00 NSF Fee will apply for
                                            Credit Card Payments that are declined. A $50.00 NSF Fee is applicable for
                                            cheque payments that are returned for insufficient funds. In addition,
                                            the Client shall be liable for the <b>shredEX</b>'s expenses for the
                                            collection
                                            of any unpaid debt including but not limited to termination fees, interest
                                            expenses, court filing fees and legal costs.</p>
                                    </li>
                                    <li><span class="font-montserrat bold">Cancellation Fee</span>
                                        <p>A Cancellation Fee of $125.00 or 50% of the service order value (whichever is
                                            greater) will apply for any service cancelled with less than 24 hours
                                            notice. For Mobile Shredding Service the Cancellation Fee of $250.00 or 100%
                                            of
                                            the Service Order Value, applies if the service is cancelled with
                                            less than 72 hours notice.</p>
                                    </li>
                                    <li><span class="font-montserrat bold">Parking Tickets</span>
                                        <p><b>shredEX</b> will make every effort to legally park for the duration of the
                                            service. However, the Client agrees to pay for any parking tickets incurred
                                            by
                                            <b>shredEX</b> while providing service to the Client, plus a $25.00
                                            administration fee.
                                        </p>
                                    </li>
                                    <li><span class="font-montserrat bold">Payments and Invoices</span>
                                        <p>The Client agrees to pay <b>shredEX</b> for all services rendered. If the
                                            Client
                                            is delinquent in payment of fees or any other charges due under this
                                            agreement for more than thirty one (31) days, the Client agrees to pay and
                                            administration of $7.50 per month per overdue invoice or calculated as
                                            an interest at the rate of 28% per annum, whichever is greater. This fee is
                                            continually applied monthly until the balance is paid in full. A $25.00 NSF
                                            Fee will apply for Credit Card or Electronic Fund Transfer Payments that are
                                            declined. A $50.00 NSF Fee is applicable for cheque payments that
                                            are returned for insufficient funds.</p>
                                        <p class="bold">If you have any questions regarding this Agreement, please
                                            contact
                                            your Account Manager at 416-255-1500 or send an email to <a
                                                href="mailto:info@shredex.ca">info@shredex.ca</a>
                                        </p>
                                    </li>
                                </ol>
                            <!-- </div> -->
                        </div>
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
                                <div class="main-title mb-3">
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

            <!-- </div> -->
        </div>
    <!-- </div> -->
</body>

</html>