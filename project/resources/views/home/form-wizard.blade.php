<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Form Wizard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.4/signature_pad.min.js"></script>

</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center bg-primary text-white">
            <h3>Multi-Step Form</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>  
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form id="wizard-form" action="{{ route('form.wizard.submit') }}" method="POST">   
                @csrf
                <!-- Step 1 -->
                   <div class="step step-1">
                    <h4>Step 1: Personal Info</h4>  
                    <div class="mb-3">
                       <label>Company Name</label>
                       <input type="hidden"  name="order_id"  value="<?php echo $order->id?>" >
                       <input type="text" class="form-control client_info"  name="company_name" id="companyName" placeholder="Company Name" value="<?php echo ($user->business_name)?$user->business_name:old('company_name')?>" >
                       @error('company_name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Contact Name</label>
                        <input type="text" class="form-control client_info" id="contact_name" name="contact_name" placeholder="Contact Name" value="<?php echo ($order->customer_name)?$order->customer_name:old('contact_name')?>" >
                        @error('contact_name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                    <label>Phone</label>
                    <input id="phone" type="tel" pattern="\d{3}\-\d{3}\-\d{4}" name="phone_number" class="form-control telephone client_info" data-mask="(999)-999-9999" placeholder="(999)-999-9999" value="<?php echo ($order->customer_phone)?$order->customer_phone:old('phone_number')?>" />
                    @error('phone_number') <div class="text-danger">{{ $message }}</div> @enderror
                     <span id="phone-error" style="color: red;"></span>
                    </div>
                   <div class="mb-3">
                      <label>Email</label>
                      <input type="email" class="form-control"  name="email" id="email" value="<?php echo ($order->customer_email)?$order->customer_email:old('email')?>"  placeholder="joan@lifeforcephysio.com">
                      @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                    <label>Addresss Line 1</label>
                    <input type="text" class="form-control client_info" id="billing_address_1" name="billing_address_1" placeholder="Addresss Line 1" value="<?php echo ($customer->address)?$customer->address:old('billing_address_1')?>" >
                    @error('billing_address_1') <div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                   <label>Addresss Line 2</label>
                   <input type="text" class="form-control" id="bill-lastName" name="billing_address_2" placeholder="Addresss Line 2" value="{{ old('billing_address_2') }}">
                   @error('billing_address_2') <div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                   <label>City</label>
                   <input type="text" class="form-control client_info" id="bill-city" name="billing_city" value="<?php echo ($customer->city)?$customer->city:old('billing_city')?>"  placeholder="City" >
                   @error('billing_city') <div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                   <label>State</label>
                   <input type="text" class="form-control " id="bill-state" name="billing_state" value="<?php echo ($customer->Province_State)?$customer->Province_State:old('billing_state')?>"  placeholder="State">
                   @error('billing_state') <div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                   <label>Postal Code</label>
                   <input type="text" class="form-control client_info" id="bill-postal" name="billing_postal_code"  placeholder="postal" value="<?php echo ($customer->zip)?$customer->zip:old('billing_postal_code')?>">
                   @error('billing_postal_code') <div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                  <label>Addresss Line 1</label>
                  <input type="text" class="form-control client_info" id="shipp-firstName" name="shipping_address_1" placeholder="Addresss Line 1" value="{{ old('shipping_address_1') }}">
                   @error('shipping_address_1')<div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                   <label>Addresss Line 2</label>
                   <input type="text" class="form-control" id="shipp-lastName" name="shipping_address_2" placeholder="Addresss Line 2" value="{{ old('shipping_address_2') }}">
                    @error('shipping_address_2')<div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                   <label>City</label>
                   <input type="text" class="form-control client_info" id="shipp-city" name="shipping_city" placeholder="City" value="{{ old('shipping_city') }}">
                    @error('shipping_city')<div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                    <label>State</label>
                    <input type="text" class="form-control" id="shipp-state" name="shipping_state" placeholder="State" value="{{ old('shipping_state') }}">
                    @error('shipping_state')<div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                    <label>Postal Code</label>
                    <input type="text" class="form-control client_info" id="shipp-postal" name="shipping_postal_code" placeholder="Postal Code" value="{{ old('shipping_postal_code') }}">
                    @error('shipping_postal_code')<div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                     <label>Phone</label>
                     <input type="text" class="form-control client_info" id="shipp-phoneNumber" name="shipping_phone" value="{{ old('shipping_phone') }}" placeholder="(999)-999-9999">
                     @error('shipping_phone')<div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" id="shipp-email" name="shipping_email" placeholder="Email" value="{{ old('shipping_email') }}">
                    @error('shipping_email')<div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <div class="mb-3">
                    <label>Pick Up Date</label>
                    <input type="text" class="form-control" placeholder="Pick Up Date" name="pick_up_date" value="{{date('m/d/Y', strtotime($order->booking_date))}}"  id="datepicker-component2" disabled>
                    @error('pick_up_date')<div class="text-danger">{{ $message }}</div> @enderror
                  </div>

                  <div class="mb-3">
                   <label>From</label>
                  <div id="selector">
                    <select class="form-control input-lg" id="operation_from" name="operation_from">
                      <option>7.00AM</option>
                      <option selected="selected">8.00AM</option>
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

                  <div class="mb-3">
                   <label>To</label>
                  <div id="selector">
                    <select class="form-control input-lg" id="operation_to" name="operation_to">
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
                      <option selected="selected">5.00PM</option>
                      <option>6.00PM</option>
                      <option>7.00PM</option>
                   </select>
                    <i class="icon-clock1"></i>
                   </div>
                  </div>
                   <div class="mb-3">
                    <label>Make It Count</label>
                    <input type="number" min="0" step="0.01" value="0.75" id="make_it_count" name="make_it_count" class="form-control">
                   </div>
                   <button type="button" class="btn btn-secondary prev">Previous</button>
                   <button type="button" class="btn btn-primary next">Next</button>
                  </div>
                  
                <!-- Step 2 -->
               <div class="step step-2 d-none">
                    <h4>Step 2: Security</h4>
                    <div class="mb-3">
                    <input type="checkbox" value="1" id="checkbox-agree" name="terms_accepted" >
                     <label for="checkbox-agree" class="fs-16 bold font-montserrat">The undersigned hereby agrees to this agreement, on behalf of the
                      Client.
                     </label>
                     @error('terms_accepted')<div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                 <button type="button" class="btn btn-secondary prev">Previous</button>
                 <button type="button" class="btn btn-primary next">Next</button>

                </div>

                <!-- Step 3 -->
              <div class="step step-3 d-none">
                    <h4>Credit Card</h4>
                    <div class="mb-3">
                         <label>Card holder's name</label>
                        <input type="text" class="form-control card_info" id="credit_card_name"  name="credit_card_name" placeholder="Name on the card" value="{{ old('credit_card_name') }}">
                        @error('credit_card_name')<div class="text-danger">{{ $message }}</div> @enderror

                    </div>
                    <div class="mb-3">
                       <label for="cardNumber">Card number</label>
                       <input type="text" class="form-control card-no card_info" id="cardNumber" name="credit_card_number" placeholder="Enter credit card number"  id="cr_no" minlength="16" maxlength="19" value="{{ old('credit_card_number') }}">
                        @error('credit_card_number')<div class="text-danger">{{ $message }}</div> @enderror
                        <span id="card-error" style="color: red;"></span>
                    </div>

                    <div class="mb-3">
                    <label class="fade">Month</label>
                    <div id="selector">
                      <select class="form-control input-lg card_info" id="exp_month" name="credit_card_expire_month">
                        <option value="1">Jan (01)</option>
                        <option value="2">Feb (02)</option>
                        <option value="3">Mar (03)</option>
                        <option value="4">Apr (04)</option>
                        <option value="5">May (05)</option>
                        <option value="6">Jun (06)</option>
                        <option value="7">Jul (07)</option>
                        <option value="8">Aug (08)</option>
                        <option value="9">Sep (09)</option>
                        <option value="10">Oct (10)</option>
                        <option value="11">Nov (11)</option>
                        <option value="12">Dec (12)</option>
                     </select>
                     <i class="fa fa-angle-down" aria-hidden="true"></i>
                      @error('credit_card_expire_month')<div class="text-danger">{{ $message }}</div> @enderror
                     </div>
                    </div>
                    <div class="mb-3">
                    <label class="fade">Year</label>
                    <div id="selector">
                      <select class="form-control input-lg card_info" id="exp_year" name="credit_card_expire_year">
                        <option selected="selected">2025</option>
                        <option>2026</option>
                        <option>2027</option>
                        <option>2028</option>
                        <option>2029</option>
                        <option>2030</option>
                        <option>2031</option>
                        <option>2032</option>
                        <option>2033</option>
                        <option>2034</option>
                        <option>2035</option>
                        <option>2036</option>
                        <option>2037</option>
                        <option>2038</option>
                        <option>2039</option>
                        <option>2040</option>
                     </select>
                     <i class="fa fa-angle-down" aria-hidden="true"></i>
                      @error('credit_card_expire_year')<div class="text-danger">{{ $message }}</div> @enderror
                     </div>
                    </div>
                    <div class="mb-3">
                      <label class="fs-14 m-25 sm-ml-0"><b>CCV Code</b></label>
                         <div class="form-group required">
                           <input class="form-control mh-55 m-25 sm-ml-0 card_info" type="password" name="credit_card_ccv" id="ccv" placeholder="000" size="1" minlength="3" maxlength="3" >
                            @error('credit_card_ccv')<div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <style type="text/css"> 
                        #signature-pad {
    width: 100%;
    max-width: 600px;
    height: 200px;
    border: 1px solid black;
    display: block;
}

                    </style>
                   <div class="mb-3">
                         <label>Signature:</label>
                        <div class="border p-2 mb-3" style="width: 100%; max-width: 250px; ">
                            <canvas id="signature-pad" class="border w-100" height="200" width="200" style="width: 100%;"></canvas>
                        </div>
                        <button type="button" class="btn btn-danger" id="clear">Clear</button>
                        <input type="hidden" name="signature" id="signature-data">
                         @error('signature')<div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                  <button type="button" class="btn btn-secondary prev">Previous</button>
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $(".next").click(function () {
        $(this).closest(".step").addClass("d-none").next().removeClass("d-none");
    });

    $(".prev").click(function () {
        $(this).closest(".step").addClass("d-none").prev().removeClass("d-none");
    });
});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var canvas = document.getElementById("signature-pad");

        // Ensure the canvas exists
        if (!canvas) {
            console.error("Signature pad canvas not found!");
            return;
        }

        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255, 255, 255, 1)', // White background
            penColor: "black" // Pen color
        });

    function resizeCanvas() {
        var parentWidth = canvas.parentElement.clientWidth; // Get parent div width
        if (parentWidth === 0) parentWidth = 250; // Set default if parent is hidden
        
        canvas.width = parentWidth;
        canvas.height = 150;
    }

    resizeCanvas();
    window.addEventListener("resize", resizeCanvas);

        // Clear Signature
        document.getElementById("clear").addEventListener("click", function () {
            signaturePad.clear();
        });

        // Handle form submission
        document.querySelector("form").addEventListener("submit", function (e) {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature.");
                e.preventDefault();
            } else {
                document.getElementById("signature-data").value = signaturePad.toDataURL("image/png");
            }
        });
    });
</script>
<script>
        $(document).ready(function () {
            $("#phone").on("input", function () {
                var phone = $(this).val();
                
                // Allow only numbers and format the input
                phone = phone.replace(/\D/g, ''); // Remove non-numeric characters

                if (phone.length > 0) {
                    phone = phone.substring(0, 10); // Limit to 10 digits
                    phone = phone.replace(/^(\d{3})(\d{0,3})(\d{0,4})$/, function (match, p1, p2, p3) {
                        return "(" + p1 + (p2 ? ")-" + p2 : "") + (p3 ? "-" + p3 : "");
                    });
                }

                $(this).val(phone);
            });

            $("#myForm").submit(function (e) {
                var phone = $("#phone").val();
                var phonePattern = /^\(\d{3}\)-\d{3}-\d{4}$/; // Regex for (999)-999-9999 format

                if (!phonePattern.test(phone)) {
                    e.preventDefault(); // Stop form submission
                    $("#phone-error").text("Please enter a valid phone number in (999)-999-9999 format.");
                } else {
                    $("#phone-error").text(""); // Clear error message
                }
            });
        });
    </script>
      <script>
        $(document).ready(function () {
            // Luhn Algorithm for credit card validation
            function luhnCheck(cardNumber) {
                let sum = 0;
                let alternate = false;
                cardNumber = cardNumber.replace(/\D/g, ''); // Remove non-numeric characters
                
                for (let i = cardNumber.length - 1; i >= 0; i--) {
                    let num = parseInt(cardNumber[i], 10);
                    
                    if (alternate) {
                        num *= 2;
                        if (num > 9) num -= 9;
                    }
                    
                    sum += num;
                    alternate = !alternate;
                }
                
                return (sum % 10 === 0);
            }

            // Validate card format
            function validateCardNumber(cardNumber) {
                cardNumber = cardNumber.replace(/\D/g, '');

                const cardPattern = /^(?:4[0-9]{12}(?:[0-9]{3})?|       # Visa
                                      5[1-5][0-9]{14}|                  # MasterCard
                                      3[47][0-9]{13}|                   # American Express
                                      6(?:011|5[0-9]{2})[0-9]{12}|      # Discover
                                      3(?:0[0-5]|[68][0-9])[0-9]{11}|   # Diners Club
                                      (?:2131|1800|35\d{3})\d{11})$/x;  # JCB

                return cardPattern.test(cardNumber) && luhnCheck(cardNumber);
            }

            // Allow only numbers while typing
            $("#cardNumber").on("input", function () {
                $(this).val($(this).val().replace(/\D/g, '')); 
            });

            // Validate on Enter key press
            $("#cardNumber").on("keypress", function (e) {
                if (e.which === 13) { // Check if Enter key is pressed
                    e.preventDefault(); // Prevent form submission

                    let cardNumber = $(this).val();
                    if (!validateCardNumber(cardNumber)) {
                        $("#card-error").text("Invalid credit card number.");
                    } else {
                        $("#card-error").text(""); // Clear error message
                    }
                }
            });

            // Validate on form submission (optional)
            $("#wizard-form").submit(function (e) {
                let cardNumber = $("#cardNumber").val();
                if (!validateCardNumber(cardNumber)) {
                    e.preventDefault();
                    $("#card-error").text("Invalid credit card number.");
                }
            });
        });
    </script>
</body>
</html>
