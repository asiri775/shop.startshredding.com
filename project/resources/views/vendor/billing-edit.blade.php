@extends('vendor.includes.master-vendor')

@section('content')
<link href="{{ URL::asset('assets/map/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/map/css/custom.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/map/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/map/css/bootstrap-4-utilities.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"></script>

    <script src="{{ URL::asset('assets/map/js/jquery1.11.3.min.js')}}"></script>
    <script src="{{ URL::asset('assets/map/js/jquery.blockUI.js')}}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- START PAGE CONTENT -->
<div class="page-title">
    <!-- START CONTAINER FLUID -->
    <div class="container-fluid p-b-50 m-t-40">

        <div class="row">
            <div class="col-sm-12 p-b-5" style="border-color: black !important">
                <div class="card card-default">
                    <div class="padding-25">
                        <div class="pull-left">
                            <h2 class="no-margin ube-card-title">Edit Cards</h2>
                            <p class="no-margin">Card Details</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card card-default">
                        <div class="card-body p-t-20">
                            <form action="{{url('/shop-billing-setting/update_credit/')}}/{{$card_detail->id}}" method="POST">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="font-clr" style="color: #a832a4">Edit CARD</label>
                                    </div>
                                </div>
                                <div class="row justify-content-left">
                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="font-clr font-sz">Cardholder_Name </label>
                                                    <div class="form-group form-group-default">
                                                        <input type="text" name="cardholder_name" id="cardholder_name" value="{{$card_detail->card_holder_name}}" class="form-control" required>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="font-clr font-sz">Card_Number </label>
                                                    <div class="form-group form-group-default">
                                                        <!-- <input type="password" name="card_number" id="card_number" value="" class="form-control" > -->
                                                        <input type="text" class="form-control card-no" value="{{$card_detail->card_number}}" name="card_number" placeholder="8888 8888 8888 8888" size="18" id="cr_no" minlength="19" maxlength="19" required>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="font-clr font-sz">EXPIRY(MM) </label>
                                                    <div class="form-group form-group-default">
                                                        <!-- <input type="text" nname="route" id="route" value="" class="form-control"> -->
                                                        <select class="form-control" id="exp_month"  name="exp_month" required>
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
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="font-clr font-sz">EXPIRY(YY) </label>
                                                    <div class="form-group form-group-default">
                                                        <!-- <input type="text" nname="route" id="route" value="" class="form-control"> -->
                                                        <select class="form-control" id="exp_year" name="exp_year" required>
                                                            <option>2024</option>
                                                            <option>2025</option>
                                                            <option>2026</option>
                                                            <option>2027</option>
                                                            <option>2028</option>
                                                            <option>2029</option>
                                                            <option>2030</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="font-clr font-sz">CCV Code</label>
                                                    <div class="form-group form-group-default">
                                                        <input type="text" name="ccv" id="ccv" placeholder="000" minlength="3" maxlength="3" value="{{$card_detail->ccv}}" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <!-- <h4 style="color: #6232a8!important;">$84.67</h4> -->
                                        <div class="btn-group">
                                            <button type="submit" style="background-color: #6232a8!important;" class="btn btn-success"><font style="font-size: 10px !important;">EDIT CARDS</font>
                                            </button>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- END CONTAINER FLUID -->

</div>
<!-- END PAGE CONTENT -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="http://cdn.datatables.net/plug-ins/1.10.15/dataRender/datetime.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  
<script src="{{ URL::asset('new_assets/assets/plugins/jquery-inputmask/jquery.inputmask.min.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function (e) {
    var exp_month = "{{$card_detail->exp_month}}";
    var exp_year = "{{$card_detail->exp_year}}";
    $('#exp_year').val(exp_year);
    $('#exp_month').val(exp_month);
        var cardNum = document.getElementById('cr_no');
        cardNum.onkeyup = function (e) {
            if (this.value == this.lastValue) return;
            var caretPosition = this.selectionStart;
            var sanitizedValue = this.value.replace(/[^0-9]/gi, '');
            var parts = [];
            
            for (var i = 0, len = sanitizedValue.length; i < len; i += 4) {
                parts.push(sanitizedValue.substring(i, i + 4));
            }
            
            for (var i = caretPosition - 1; i >= 0; i--) {
                var c = this.value[i];
                if (c < '0' || c > '9') {
                    caretPosition--;
                }
            }
            caretPosition += Math.floor(caretPosition / 4);
            
            this.value = this.lastValue = parts.join(' ');
            this.selectionStart = this.selectionEnd = caretPosition;
        }
    })
</script>
<!-- END PAGE LEVEL JS -->
@endsection

@section('footer')

@stop