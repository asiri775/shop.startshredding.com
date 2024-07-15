@extends('home.shop.user.new_main')
@section('title','My Account')
@section('content')
    <!-- START PAGE CONTENT -->
    <div class="content ">
        <div class="container-fluid p-b-50 m-t-40">
            <div class="row">
                <div class="col-md-8">
                    <!-- START card -->
                    <div class="card card-borderless">
                        <ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex"
                            role="tablist" data-init-reponsive-tabs="dropdownfx">
                            <li class="nav-item">
                                <a class="" data-toggle="tab" role="tab"
                                   data-target="#tab2hellowWorld" href="#" aria-selected="true">Account
                                    Info</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" data-toggle="tab" role="tab" data-target="#tab2FollowUs" class="active show"
                                   aria-selected="false">Saved Adress</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" data-toggle="tab" role="tab" data-target="#tab2Inspire" class=""
                                   aria-selected="false">Change Password</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane " id="tab2hellowWorld">
                                <div class="row column-seperation">
                                    <div class="col-lg-12">
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
                                        <form action="{{ route('home.user-update',['id' => $user->id]) }}" method="POST" class="" id="form-account" role="form">
                                        {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default required">
                                                        <label>First name</label>
                                                        <input class="form-control" type="text" name="first_name" id="dash_fname" value="{{$user->first_name}}" placeholder="" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Last name</label>
                                                        <input class="form-control" type="text" name="last_name" id="dash_lname" value="{{$user->last_name}}" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default required">
                                                        <label>Email</label>
                                                        <input class="form-control" type="email" name="email" value="{{$user->email}}" id="dash_email" required >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default required">
                                                        <label>Mobile Number</label>
                                                        <input class="form-control" type="text" name="phone" id="yourphone" value="{{$user->phone}}" placeholder="Phone Number" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default ">
                                                        <label>Instagram</label>
                                                        <input class="form-control" type="text" name="instagram" id="instagram" value="{{$user->instagram}}" placeholder="" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>FaceBook</label>
                                                        <input class="form-control" type="text" name="face_book" id="face_book" value="{{$user->face_book}}" placeholder="" >
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-cons m-t-10" type="submit">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane active show" id="tab2FollowUs">
                                <div class="row column-seperation">
                                    <div class="col-lg-12">
                                        @if(Session::has('message1'))
                                            <div class="alert alert-success alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ Session::get('message1') }}
                                            </div>
                                        @endif
                                        <form class="" id="form-contact" role="form">
                                            {{csrf_field()}}
                                            <div class="col-lg-12 col-xl-12 col-xlg-5 p-b-5" style="border-color: black !important">
                                                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle full-height d-flex flex-column">
                                                    <div class="card-header  top-right">
                                                        <div class="card-controls">
                                                        </div>
                                                    </div>
                                                    <div class="auto-overflow">
                                                        <table class="table  table-hover " id="tableStore1">
                                                            <thead>
                                                            <tr class="text-center">
                                                                <th class="all-caps">Alias</th>
                                                                <th class="all-caps">Address</th>
                                                                <th class="all-caps"></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($multiple_address as $multi_address)
                                                                <tr class="text-center">
                                                                    <td class="fs-12">{{$multi_address->address_alias}}</td>
                                                                    <td class="fs-12">{{$multi_address->address}}</td>
                                                                    <td class="fs-12">
                                                                        <a href="{{ route('home.multiple-address-edit', ['id' => $multi_address->id]) }}" id="edit_multiaddress" class="bg-free-btn">Edit
                                                                        </a>
                                                                        @if($multi_address->address_alias !== 'Default')
                                                                        |
                                                                        <a href="{{ route('home.multiple-address-remove', ['id' => $multi_address->id]) }}"
                                                                            id="remove_multiaddress"
                                                                            class="bg-free-btn">Delete
                                                                        </a>
                                                                        @endif
                                                                    </td>

                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </form>
                                    </div>
                                </div>
                                <div class="row column-seperation">
                                    <div class="auto-overflow col-lg-12">
                                        <form action="{{ route('home.updateMultipleAddress',['id' => $edit_address->id]) }}" method="POST" class="" id="form-contact1" role="form">
                                            {{ csrf_field() }}

                                            <div class="col-lg-12 col-xl-12 col-xlg-5 p-b-5" style="border-color: black !important">
                                                <div class="">
                                                    <br>
                                                    <div class=" widget-11-2-table">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group form-group-default">
                                                                 <label class="font-clr">ADD NEW ADDRESS</label>
                                                                    <input id="pac-input" type="text" value="{{$edit_address->address}}" class="form-control" required>
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6" >
                                                                <div id="map" style="height: 360px;width: 100%"></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                
                                                                <div class="form-group form-group-default">
                                                                <label class="font-clr">STREET</label>
                                                                    <input type="text" name="street" id="route" value="{{$edit_address->street}}" class="form-control" disabled="true">
                                                                </div>
                                                               
                                                                <div class="form-group form-group-default">
                                                                <label class="font-clr">CITY</label>
                                                                    <input name="city" id="locality" value="{{$edit_address->city}}" type="text" class="form-control" disabled="true">
                                                                </div>
                                                                
                                                                <div class="form-group form-group-default">
                                                                <label class="font-clr">PROVINCE</label>
                                                                    <input name="administrative_area_level_1" id="administrative_area_level_1" type="text" value="{{$edit_address->province}}" class="form-control" disabled="true">
                                                                </div>
                                                                
                                                                <div class="form-group form-group-default">
                                                                <label class="font-clr">POSTAL CODE</label>
                                                                    <input type="text" value="{{$edit_address->zip}}" name="zip" id="postal_code" class="form-control" required>
                                                                </div>
                                                                
                                                                <div class="form-group form-group-default">
                                                                <label class="font-clr">SET AS A DEFAULT ADDRESS</label>
                                                                    @if($edit_address->address_alias=="Default")
                                                                        <input type="checkbox" checked="checked" name="address_alias" id="address_alias" value="Default">
                                                                    @else
                                                                        <input type="checkbox"  name="address_alias" id="address_alias" value="Default">
                                                                    @endif
                                                                </div>
                                                              
                                                                <input type="hidden" name="latitude" id="latitude" value="{{$edit_address->latitude }}"/>
                                                                <input type="hidden" name="logtitude" id="longitude" value="{{$edit_address->longitude }}"/>
                                                              
                                                                <input class="field" value="" name="country" id="country" disabled="true" hidden/>
                                                                <input class="field" value="" name="street_number" id="street_number" disabled="true" hidden/>
                                                                <input type="hidden" value="" name="latitude" id="lat">
                                                                <input type="hidden" value="" name="longitude" id="lng">
                                                                <input type="hidden" value="" name="address" id="location">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <br>


                                                </div>
                                            </div>
                                         
                                            <div class="col-sm-12">
                                            <button  class="btn btn-primary btn-cons m-t-10" type="submit">UPDATE
                                                ADDRESS</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane" id="tab2Inspire">
                                <div class="row column-seperation">
                                    <div class="col-lg-12">
                                        @if(Session::has('error'))
                                            <div class="alert alert-danger alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ Session::get('error') }}
                                            </div>
                                        @endif
                                        @if(Session::has('message'))
                                            <div class="alert alert-success alert-dismissable">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                {{ Session::get('message') }}
                                            </div>
                                        @endif
                                        <form action="{{ route('home.user-password-change',['id' => $user->id]) }}" method="POST" class="" id="form-password" role="form">
                                            {{ csrf_field() }}
                                            <div class="form-group  form-group-default required">
                                                <label>Old Password</label>
                                                <input class="form-control" type="password" name="oldpass" id="old_password" required>
                                            </div>
                                            <div class="form-group  form-group-default required">
                                                <label>New Password</label>
                                                <input class="form-control" type="password" name="newpass" id="new_password" required>
                                            </div>
                                            <div class="form-group  form-group-default required">
                                                <label>Password Confirm</label>
                                                <input class="form-control" type="password" name="renewpass" id="change_password" required>
                                            </div>
                                            <button class="btn btn-primary btn-cons m-t-10" type="submit">Change
                                                Password</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTAINER FLUID -->
    </div>

    <!-- END PAGE CONTENT -->
@endsection
@section('scripts')

    <script src="{{ URL::asset('new_assets/assets/plugins/jquery/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>

    <script src="{{ URL::asset('new_assets/assets/plugins/pace/pace.min.js')}}"  type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/modernizr.custom.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/popper/umd/popper.min.js')}}" src="" type="text/javascript"></script>

    <script src="{{ URL::asset('new_assets/assets/plugins/jquery/jquery-easy.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/jquery-unveil/jquery.unveil.min.js')}}"  type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/jquery-ios-list/jquery.ioslist.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/jquery-ios-list/jquery.ioslist.min.js')}}"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/classie/classie.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/switchery/js/switchery.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/bootstrap-tag/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/jquery-inputmask/jquery.inputmask.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js')}}"  type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/datatables-responsive/js/datatables.responsive.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('new_assets/assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>


    <script src="{{ URL::asset('new_assets/assets/js/datatables.js')}}" type="text/javascript"></script>

    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="{{ URL::asset('new_assets/pages/js/pages.js')}}"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="{{ URL::asset('new_assets/assets/js/scripts.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="{{ URL::asset('new_assets/assets/js/demo.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/js/jquery.maskedinput.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRu_qlT0HNjPcs45NXXiOSMd3btAUduSc&libraries=places&callback=initMap" async defer></script>
    <script>
        jQuery(function($){
            $("#yourphone").mask("(999) 999 - 9999");

        });

        $(document).ready(function(){

        });

    </script>
    <script>

        function initMap() {
                
            var lat=document.getElementById("latitude").value;
            var long=document.getElementById("longitude").value;

            var latitude = parseFloat(lat);
            var longitude = parseFloat(long);
       
            // The location of Uluru
            var uluru = {lat: latitude, lng: longitude};
            var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 15, center: uluru});
            // The map, centered at Uluru
            // var map = new google.maps.Map(
            // document.getElementById('map'), {zoom: 15, center: uluru});
            // // The marker, positioned at Uluru
            // var marker = new google.maps.Marker({position: uluru, map: map});    
            
            // var map = new google.maps.Map(document.getElementById('map'), {
            //     center: {lat: 55.585901, lng: -105.750596},
            //     zoom: 5,
                  
            // });
            var options = {
                types: ['geocode'],  // or '(cities)' if that's what you want?
                componentRestrictions: {country:["us","ca"]}
            };
            var marker = new google.maps.Marker({position: uluru, map: map}); 
            var componentForm = {
                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'short_name',
                country: 'long_name',
                postal_code: 'short_name'
            };
            var input = /** @type {!HTMLInputElement} */(document.getElementById('pac-input'));
            var types = document.getElementById('type-selector');
            //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

            var autocomplete = new google.maps.places.Autocomplete(input,options);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            autocomplete.addListener('place_changed', function() {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();

                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);  // Why 17? Because it looks good.
                }
                marker.setIcon(/** @type {google.maps.Icon} */({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                var item_Lat =place.geometry.location.lat()
                var item_Lng= place.geometry.location.lng()
                var item_Location = place.formatted_address;
                //alert("Lat= "+item_Lat+"_____Lang="+item_Lng+"_____Location="+item_Location);
                $("#lat").val(item_Lat);
                $("#lng").val(item_Lng);
                $("#location").val(item_Location);
                $("#location1").val(item_Location);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }
                for (var component in componentForm) {
                    document.getElementById(component).value = '';
                    document.getElementById(component).disabled = false;
                }
                // Get each component of the address from the place details,
                // and then fill-in the corresponding field on the form.
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    if (componentForm[addressType]) {
                        var val = place.address_components[i][componentForm[addressType]];
                        document.getElementById(addressType).value = val;
                    }
                }
                console.log(val);
                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                infowindow.open(map, marker);
            });

            // Sets a listener on a radio button to change the filter type on Places
            // Autocomplete.
            function setupClickListener(id, types) {
                var radioButton = document.getElementById(id);
                /*radioButton.addEventListener('click', function() {
                autocomplete.setTypes(types);
                });*/
            }

            setupClickListener('changetype-all', []);
            setupClickListener('changetype-address', ['address']);
            setupClickListener('changetype-establishment', ['establishment']);
            setupClickListener('changetype-geocode', ['geocode']);
        }
    </script>


    <script>
        incrementVar = 1;
        function incrementValue(elem){
            var $this = $(elem);
            $input = $this.prev('input');
            $parent = $input.closest('div');
            newValue = parseInt($input.val())+1;
            $parent.find('.inc').addClass('a'+newValue);
            $input.val(newValue);
            incrementVar += newValue;
        }
        function decrementValue(elem){
            var $this = $(elem);
            $input = $this.next('input');
            $parent = $input.closest('div');
            newValue = parseInt($input.val())-1;
            $parent.find('.inc').addClass('a'+newValue);
            if(newValue <= 1){
                $input.val(1);
            }else{
                $input.val(newValue);
            }
            incrementVar += newValue;
        }
    </script>
    <script>
        function myMap() {
            var mapProp= {
                center:new google.maps.LatLng(51.508742,-0.120850),
                zoom:5,
            };
            var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
        }
    </script>
    <!-- END PAGE LEVEL JS -->
@endsection