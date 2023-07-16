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
    <link rel="stylesheet" href="{{ asset('public/') }}{{ asset('public/') }}assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('public/') }}{{ asset('public/') }}assets/css/stye.css" />
</head>
<body>
    
    <main class="d-flex flex-column min-vh-100">
        <header class="bg-white sticky-top">
            <div class="container_lg">
                <div class="header_inner border-bottom border-gray">
                    <div class="header_first_row row g-0 mx-0">
                        <div class="col-auto px-0">
                            <a href="/" class="logo">
                                <img src="{{ asset('public/') }}assets/images/logo.png" alt="Logo" class="img-fluid" />
                            </a>
                        </div>
                        <div class="col flex-grow-1 pl-0 location_row">
                            <div class="location_form">
                                <form action="">
                                    <div class="form-group search_bar">
                                        <input type="search" name="search" placeholder="Search..." class="appearance-none bg-transparent">
                                        <span class="d-block my-2 border-left border-gray"></span>
                                        <button type="submit">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="fa-magnifying-glass "><path fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>
                                        </button>
                                    </div>
                                    <button data-target="#locationModal" data-toggle="modal" type="button" class="location-dtl fw-600 border-none align-items-center text-theme rounded-pill py-2">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-location-dot border-b border-transparent"><path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path></svg>
                                        <span class="d-block ml-2 overflow-hidden overflow-ellipsis text-nowrap transition-all">Miami, Florida</span>
                                        <span class="ms-3 ml-xl-1 fw-400 align-items-center text-nowrap">:50 miles</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-auto pr-0">
                            <div class="btn-group d-none d-md-inline-flex">
                                <button type="button" class="btn btn-secondary" data-toggle="dropdown" aria-expanded="false">About <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"></path></svg></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item">About</a>
                                    <a href="#" class="dropdown-item">Terms & Conditions</a>
                                    <a href="#" class="dropdown-item">Privacy Policy</a>
                                </div>
                            </div>
                            <!-- <div class="btn-group d-none d-md-inline-flex">
                                <button type="button" class="btn btn-secondary" data-toggle="dropdown" aria-expanded="false">Inbox <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"></path></svg></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div role="none"><p class="text-center textGray fw-400 text-base mb-0 py-2" role="none">No new notifications.</p></div>
                                    <div class="d-flex flex-column align-items-center justify-content-center border-top px-2 py-2 border-gray" role="none">
                                        <a href="#" class="text-sm fw-600 text-theme" role="none">View All Notifications</a>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group d-none d-md-inline-flex">
                                <button type="button" class="btn btn-secondary" data-toggle="dropdown" aria-expanded="false">Account <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"></path></svg></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item">My Cars</a>
                                    <a href="#" class="dropdown-item">Account Settings</a>
                                    <a href="#" class="dropdown-item">Blocked Users</a>
                                    <a href="#" class="dropdown-item">Logout <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="right-from-bracket" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-right-from-bracket text-sm"><path fill="currentColor" d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></a>
                                </div>
                            </div> -->
                            <div class="sign_btns">
                                <a href="javascript:void(0);" data-target="#signinModal" data-toggle="modal" class="sign-in-popup-btn">Signin</a>
                                <a href="#" data-target="#signupModal" data-toggle="modal" class="sign-up-popup-btn">Signup</a>
                                <!-- <a href="#" class="text-sm fw-500 border border-theme textGray rounded-pil post_btn">Post a Tiny Home <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus ml-2"><path fill="currentColor" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path></svg></a> -->
                                <a href="javascript:void(0);" class="menu_icon d-xl-none" id="show_menu">
                                    <i class="fa fa-bars"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="header_last_row row mx-0">
                        <div class="col px-0">
                            <h3 class="mb-0">Find a Tinny Home</h3>
                            <ul class="menu_list">
                                <li><a href="#">Tiny Houses</a></li>
                                <li><a href="#">Deck Trailers</a></li>
                                <li><a href="#">Tiny  House Trailers</a></li>
                                <li><a href="#">Off-Grid</a></li>
                                <li><a href="#">Loft Bedroom Models</a></li>
                                <li><a href="#">Ground Level Bedroom Models</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mobile_menu d-xl-none">
                    <div class="header_first_row row g-0 mx-0">
                        <div class="col-auto px-0">
                            <a href="/" class="logo">
                                <img src="{{ asset('public/') }}assets/images/logo.png" alt="Logo" class="img-fluid" />
                            </a>
                        </div>
                        <div class="col-auto pr-0">
                            <div class="sign_btns">
                                <a href="#" class="text-sm fw-500 border border-theme textGray rounded-pil post_btn">Post a Tiny Home <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus ml-2"><path fill="currentColor" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path></svg></a>
                                <a href="javascript:void(0);" class="menu_icon d-xl-none" id="close_menu">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="menu_list">
                        <ul>
                            <li>
                                <a href="#">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-message  text-base text-gray-700 mr-4"><path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path></svg>
                                    <span>Messages</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bell" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-bell  text-base text-gray-700 mr-4"><path fill="currentColor" d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"></path></svg>
                                    <span>Notifications</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-home"></i>
                                    <span>My Tiny House</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-user  text-base text-gray-700 mr-4"><path fill="currentColor" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"></path></svg>
                                    <span>Account Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="users" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-users  text-base text-gray-700 mr-4"><path fill="currentColor" d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"></path></svg>
                                    <span>Blocked Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle-info" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-circle-info  text-base text-gray-700 mr-4"><path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <span>About</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="list" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-list  text-base text-gray-700 mr-4"><path fill="currentColor" d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z"></path></svg>
                                    <span>Terms & Conditions</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="lock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-lock  text-base text-gray-700 mr-4"><path fill="currentColor" d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"></path></svg>
                                    <span>Privacy Policy</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="right-from-bracket" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-right-from-bracket  text-base text-gray-700 mr-4"><path fill="currentColor" d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg>
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>
                        <div class="categoried_item">
                            <h4 class="text-lg font-weight-bold textDark">Categories</h4>
                            <ul>
                                <li><a href="#">Tiny Houses</a></li>
                                <li><a href="#">Deck Trailers</a></li>
                                <li><a href="#">Tiny  House Trailers</a></li>
                                <li><a href="#">Off-Grid</a></li>
                                <li><a href="#">Loft Bedroom Models</a></li>
                                <li><a href="#">Ground Level Bedroom Models</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>



        <footer class="bg-white">
            <div class="container_lg">
                <div class="footer_inner border-top border-gray">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="text-gray-800 font-normal text-center mb-md-0">© 2023<span class="text-uppercase text-theme px-1 fw-600">Tiny Homes Sales.</span>All Rights Reserved.</p>
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary" type="button" data-toggle="dropdown" aria-expanded="false">English <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-chevron-down text-sm transition-all text-gray-600 ui-open:rotate-180"><path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"></path></svg></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">English</a>
                                    <a class="dropdown-item" href="#">Spanish</a>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </footer>
    </main>


    <!-- Location Modal -->
    <div class="modal fade cusmodal" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-670">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-xmark"><path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path></svg>
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
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-xmark"><path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path></svg>
                    </button>
                    <div>
                        <div class="logo text-center mb-2">
                            <img src="{{ asset('public/') }}assets/images/logo.png" alt="logo" class="img-fluid" />
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
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" class="svg-inline--fa fa-google mr-4"><path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path></svg>
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
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-xmark"><path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path></svg>
                    </button>
                    <div>
                        <div class="logo text-center mb-2">
                            <img src="{{ asset('public/') }}assets/images/logo.png" alt="logo" class="img-fluid" />
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
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" class="svg-inline--fa fa-google mr-4"><path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path></svg>
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

    <script src="{{ asset('public/') }}assets/js/jquery.slim.min.js"></script>
    <script src="{{ asset('public/') }}assets/js/popper.min.js"></script>
    <script src="{{ asset('public/') }}assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('public/') }}assets/js/custom.js"></script>
</body>
</html>