@extends('layouts.session')
@section('page_style')
<style>

</style>
@endsection
@section('content')

<div class="content-wrapper">
    <div class="content-inner">
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <!-- Display success message -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif


        <div class="modal1  cusmodal">
            <div class="modal-dialog modal-dialog-centered modal-670">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-xmark">
                                <path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                            </svg>
                        </button>
                        <div>
                            <div class="logo text-center mb-2">
                                <img src="{{ asset('public/') }}/assets/images/logo.png" alt="logo" class="img-fluid" />
                            </div>
                            <div class="mt-10 w-100">
                                <form class="login-form" action="{{ url('signup') }}" method="post" autocomplete="off">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First name" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                            @error('first_name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" name="last_name" placeholder="Last name" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                            @error('last_name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="Email" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" placeholder="Password" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                        @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                        @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" name="mobile" placeholder="Phone Number" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                        @error('mobile')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="address" name="address1" placeholder="Address" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                        @error('addess_line_1')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="terms py-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="accept_term_and_conditons" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">I understand the rule &amp; I accept the <a href="#" class="pl-1 text-white">Terms &amp; Conditions.</a></label>
                                        </div>
                                        @error('accept_term_and_conditons')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <input type="hidden" name="state" id="state">
                                    <input type="hidden" name="zip_code" id="zip_code">
                                    <input type="hidden" name="country" id="coutry">
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">

                                    <button type="submit" id="#continueBtn" onclick="storeLocationLatLng('address')" class="btn-light w-100 mt-3">Continue</button>

                                </form>
                                <!-- <button type="button" class="btn-light w-100 mt-4">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" class="svg-inline--fa fa-google mr-4">
                                    <path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path>
                                </svg>
                                <span>Continue With Google</span>
                            </button> -->
                                <div class="mt-10 w-100 text-center">
                                    <a href="{{url('/login')}}" class="cursor-pointer text-white">Already a member? Sign in</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>
@endsection
@section('page_script')
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $("#email").val("");
            $("#password").val("");
        }, 500)
        $("#admin-login-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                },
            },
            message: {
                email: 'Email field is required',
                password: 'Password field is required',
            },
            errorElement: 'span',
            errorClass: 'error text-danger',
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPMJgzQhnqDBw6YL8Zd1rFk8L402-tSw0&libraries=places"></script>

<script>
    
    // Function to initialize Autocomplete
    initAutocomplete('address');

    function initAutocomplete(id) {
        const locationInput = document.getElementById(id);
        const autocomplete = new google.maps.places.Autocomplete(locationInput);
        
    }

    // Function to store latitude and longitude in local storage
    function storeLocationLatLng(id) {

        $.noConflict();
        const locationInput = document.getElementById(id);
        const place = locationInput.value;

        // Perform Geocoding to get the latitude and longitude
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            address: place
        }, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                const lat = results[0].geometry.location.lat();
                const lng = results[0].geometry.location.lng();
                const address = results[0].formatted_address;

                console.log(lng);
                console.log(address);

                

                // Extract additional address components
                let zipCode = "";
                let state = "";
                let country = "";
                for (const component of results[0].address_components) {
                    for (const type of component.types) {
                        if (type === "postal_code") {
                            zipCode = component.long_name;
                        } else if (type === "administrative_area_level_1") {
                            state = component.long_name;
                        } else if (type === "country") {
                            country = component.long_name;
                        }
                    }
                }

                // Store additional address components in local storage (optional)
                // Store latitude and longitude in local storage
           

           

                $('#zip_code').val(zipCode);
                $('#latitude').val(lat);
                $('#longitude').val(lng);
                $('#zip_code').val(zipCode);
                $('#state').val(state);
                $('#county').val(country);

            

                const addressElement = document.getElementById('addresid'); // Replace 'address_element_id' with the ID of the element where you want to display the address
                addressElement.textContent = address;

                $('#locationModal').modal('hide');


            }
        });
    }

    // Load the Google Maps API and initialize Autocomplete
    google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>
@endsection
@section('page_style')
<style>
</style>
@endsection