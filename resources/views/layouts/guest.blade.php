<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/images/logo.png') }}">

    <title>Tiny Home Sales</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/') }}/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('public/') }}/assets/css/stye.css" />
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPMJgzQhnqDBw6YL8Zd1rFk8L402-tSw0&libraries=places"></script>

    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> -->


    @yield('page_style')
</head>

<body>
    <main class="d-flex flex-column min-vh-100">
        @include('layouts.user.header')
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
        @yield('content')
        @include('layouts.user.footer')
    </main>
    <!-- Location Modal -->
    <div class="modal fade cusmodal" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-670">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-xmark">
                            <path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                        </svg>
                    </button>
                    <div>
                        <h4 class="text-xl mb-0 font-weight-bold uppercase">CHOOSE LOCATION</h4>
                        <div class="mt-10 w-100">
                            <input type="text" placeholder="Enter Location" id="location_main" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                            <button type="button" class="btn-light w-100 mt-3" onclick="storeLocationLatLng('location_main')">Continue</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sign in Modal -->
    <!-- <div class="modal fade cusmodal" id="signinModal" tabindex="-1" aria-labelledby="signinModalLabel" aria-hidden="true">
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
                            <div class="form-group">
                                <input type="email" placeholder="Email" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="Password" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                            </div>
                            <a href="#" class="ml-3 text-white fw-500">Forgot Password?</a>
                            <button type="button" class="btn-light w-100 mt-3">Continue</button>
                            <div class="terms py-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">I understand the rule &amp; I accept the <a href="#" class="pl-1 text-white">Terms &amp; Conditions.</a></label>
                                </div>
                            </div>
                            <button type="button" class="btn-light w-100">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" class="svg-inline--fa fa-google mr-4">
                                    <path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path>
                                </svg>
                                <span>Continue With Google</span>
                            </button>
                            <div class="mt-10 w-100 text-center">
                                <a href="#" class="cursor-pointer text-white">Not a member? Create an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Sign up Modal -->

    <script src="{{ asset('public/') }}/assets/js/jquery.slim.min.js"></script>
    <script src="{{ asset('public/') }}/assets/js/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('public/') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('public/') }}/assets/js/slick.min.js"></script>

    <script src="{{ asset('public/') }}/assets/js/custom.js"></script>

    @yield('page_script')



    <script>
        function showToast(isSuccess, message) {
            // Get the toast container element
            var type = 'success';
            if (isSuccess) {
                type = 'success';
            } else {
                type = 'danger';

            }
            const toastContainer = $('.toast-container');

            // Create the toast alert with the specified type and message
            const toast = $('<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true" data-delay="3000">')
                .addClass('toast-' + type)
                .append('<div class="toast-header"><strong class="mr-auto">Alert</strong><button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
                .append('<div class="toast-body">' + message + '</div>');

            // Append the toast alert to the container and show it
            toastContainer.append(toast);
            toast.toast('show');
        }
        //   showToast('success', 'House posted successfully.');
    </script>



    <script>
        // Function to initialize Autocomplete
        initAutocomplete('location_main');
        initAutocomplete('locationInput');

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

                    // Store latitude and longitude in local storage
                    localStorage.setItem('selected_location_lat', lat);
                    localStorage.setItem('selected_location_lng', lng);

                    const addressElement = document.getElementById('addresid'); // Replace 'address_element_id' with the ID of the element where you want to display the address
                    addressElement.textContent = address;

                    $('#locationModal').modal('hide');


                }
            });
        }

        // Load the Google Maps API and initialize Autocomplete
        google.maps.event.addDomListener(window, 'load', initAutocomplete);
    </script>

    <script>
        $(document).ready(function() {
            function getQueryParameter(name) {
                var urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }

            // Get the value of the 'search_term' query parameter
            var searchValue = getQueryParameter('search_term');

            // Set the value of the search input
            $('input[name="search_term"]').val(searchValue);

            // Rest of your code...

        });
    </script>






</body>

</html>