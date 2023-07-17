<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiny Homes Sales</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/') }}/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('public/') }}/assets/css/stye.css" />
</head>

<body>
    <main class="d-flex flex-column min-vh-100">
        @include('layouts.user.header')
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
                            <input type="text" placeholder="Enter Location" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                            <button type="button" class="btn-light w-100 mt-3">Continue</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sign in Modal -->
    <div class="modal fade cusmodal" id="signinModal" tabindex="-1" aria-labelledby="signinModalLabel" aria-hidden="true">
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
    </div>

    <!-- Sign up Modal -->
    <div class="modal fade cusmodal" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
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
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" placeholder="First name" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" placeholder="Last name" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" placeholder="Email" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="Password" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="Confirm Password" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="tel" placeholder="Phone Number" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                            </div>
                            <div class="terms py-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">I understand the rule &amp; I accept the <a href="#" class="pl-1 text-white">Terms &amp; Conditions.</a></label>
                                </div>
                            </div>
                            <button type="button" class="btn-light w-100 mt-3">Continue</button>
                            <button type="button" class="btn-light w-100 mt-4">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" class="svg-inline--fa fa-google mr-4">
                                    <path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path>
                                </svg>
                                <span>Continue With Google</span>
                            </button>
                            <div class="mt-10 w-100 text-center">
                                <a href="#" class="cursor-pointer text-white">Already a member? Sign in</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('public/') }}/assets/js/jquery.slim.min.js"></script>
    <script src="{{ asset('public/') }}/assets/js/popper.min.js"></script>
    <script src="{{ asset('public/') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('public/') }}/assets/js/slick.min.js"></script>
    <script src="{{ asset('public/') }}/assets/js/custom.js"></script>

  
   
</body>

</html>