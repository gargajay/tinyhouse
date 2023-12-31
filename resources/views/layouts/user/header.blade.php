<?php

use App\Models\Car;

$categories = Car::getcategories();
?>

<header class="bg-white sticky-top">
    <div class="container_lg">
        <div class="header_inner border-bottom border-gray">
            <div class="header_first_row row g-0 mx-0">
                <div class="col-auto px-0">
                    <a href="{{url('/')}}" class="logo">
                        <img src="{{ asset('public/') }}/assets/images/logo.png" alt="Logo" class="img-fluid" />
                    </a>
                </div>
                <div class="col flex-grow-1 pl-0 location_row">
                    <div class="location_form">
                        <form action="{{url('search')}}">
                            <div class="form-group search_bar">
                                <input type="search" name="search_term" placeholder="Search..." value="{{old('search_term')}}" class="appearance-none bg-transparent">
                                <span class="d-block my-2 border-left border-gray"></span>
                                <button type="submit">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="fa-magnifying-glass ">
                                        <path fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path>
                                    </svg>
                                </button>
                            </div>
                            <button data-target="#locationModal" data-toggle="modal" type="button" class="location-dtl fw-600 border-none align-items-center text-theme rounded-pill py-2">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-location-dot border-b border-transparent">
                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                </svg>
                                <span class="d-block ml-2 overflow-hidden overflow-ellipsis text-nowrap transition-all" id="addresid">Gold coast, queensland</span>
                                <span class="ms-3 ml-xl-1 fw-400 align-items-center text-nowrap">:50 km</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-auto pr-0">
                    <div class="btn-group d-none d-md-inline-flex">
                        <button type="button" class="btn btn-secondary" data-toggle="dropdown" aria-expanded="false">About <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"></path>
                            </svg></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{url('about')}}" class="dropdown-item">About</a>
                            <a href="{{url('terms-and-conditions')}}" class="dropdown-item">Terms & Conditions</a>
                            <a href="{{url('privacy-pollcy')}}" class="dropdown-item">Privacy Policy</a>
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
                            </div> -->




                    @auth

                    <div class="btn-group d-none d-md-inline-flex">
                        <button type="button" class="btn btn-secondary" data-toggle="dropdown" aria-expanded="false">Account<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"></path>
                            </svg></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{url('my-home')}}" class="dropdown-item">My Home</a>
                            <a href="{{url('account-setting')}}" class="dropdown-item">Account Settings</a>
                            <a href="{{ route('admin.logout') }}" class="dropdown-item">Logout <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="right-from-bracket" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-right-from-bracket text-sm">
                                    <path fill="currentColor" d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                                </svg></a>
                        </div>
                    </div>
                    @endauth
                    <div class="sign_btns">
                        @guest
                        <a href="{{url('/login')}}" class="sign-in-popup-btn">Signin</a>
                        <a href="{{url('/signup')}}" >Signup</a>

                        @else
                        <a href="{{url('create-post')}}" class="text-sm fw-500 border border-theme textGray rounded-pil post_btn">Post a Tiny Home <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus ml-2">
                                <path fill="currentColor" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path>
                            </svg></a>
                        <a href="{{url('create-post')}}" class="menu_icon d-xl-none" id="show_menu">
                            <i class="fa fa-bars"></i>
                        </a>
                        @endguest



                    </div>
                </div>
            </div>
            <div class="header_last_row row mx-0">
                <div class="col px-0">
                    <h3 class="mb-0">Find a Tiny Homes</h3>
                    <ul class="menu_list">
                    @forelse($categories as $listing)
                    @php
                $categoryId = $listing->id;
                $activeClass = '';
                if (request()->has('category_id') && request()->query('category_id') == $categoryId) {
                    $activeClass = 'active';
                }
            @endphp
                    <li><a href="{{url('search?category_id='.$listing->id)}}" class= " {{$activeClass}}" data-category="{{$listing->id}}">{{$listing->title}}</a></li>
                    @empty

                    @endforelse
                       
                    </ul>
                </div>
            </div>
        </div>
        <div class="mobile_menu d-xl-none">
            <div class="header_first_row row g-0 mx-0">
                <div class="col-auto px-0">
                    <a href="/" class="logo">
                        <img src="{{ asset('public/') }}/assets/images/logo.png" alt="Logo" class="img-fluid" />
                    </a>
                </div>
                <div class="col-auto pr-0">
                    <div class="sign_btns">
                        <a href="{{ url('create-post')}} " class="text-sm fw-500 border border-theme textGray rounded-pil post_btn">Post a Tiny Home <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus ml-2">
                                <path fill="currentColor" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path>
                            </svg></a>
                        <a href="{{url('create-post')}}" class="menu_icon d-xl-none" id="close_menu">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="menu_list">
                <ul>
                    <!-- <li>
                        <a href="#">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-message  text-base text-gray-700 mr-4">
                                <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                            </svg>
                            <span>Messages</span>
                        </a>
                    </li> -->
                    <!-- <li>
                        <a href="#">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bell" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-bell  text-base text-gray-700 mr-4">
                                <path fill="currentColor" d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"></path>
                            </svg>
                            <span>Notifications</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="{{ url('my-home') }}">
                            <i class="fa fa-home"></i>
                            <span>My Tiny House</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('account-setting') }}">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-user  text-base text-gray-700 mr-4">
                                <path fill="currentColor" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"></path>
                            </svg>
                            <span>Account Settings</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="#">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="users" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-users  text-base text-gray-700 mr-4">
                                <path fill="currentColor" d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"></path>
                            </svg>
                            <span>Blocked Users</span>
                        </a>
                    </li> -->
                    

                    <li>
                        <a href="{{url('about')}}">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle-info" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-circle-info  text-base text-gray-700 mr-4">
                                <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path>
                            </svg>
                            <span>About</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('terms-and-conditions')}}">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="list" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-list  text-base text-gray-700 mr-4">
                                <path fill="currentColor" d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z"></path>
                            </svg>
                            <span>Terms & Conditions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('privacy-pollcy')}}">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="lock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-lock  text-base text-gray-700 mr-4">
                                <path fill="currentColor" d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"></path>
                            </svg>
                            <span>Privacy Policy</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('logout')}}">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="right-from-bracket" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-right-from-bracket  text-base text-gray-700 mr-4">
                                <path fill="currentColor" d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                            </svg>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
                <div class="categoried_item">
                    <h4 class="text-lg font-weight-bold textDark">Categories</h4>
                    <ul>
                    @forelse($categories as $listing)
                    <li><a href="#{{$listing->id}}">{{$listing->title}}</a></li>
                    @empty

                    @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>



<div aria-live="polite" aria-atomic="true" class="position-fixed toast-container" style="top:-100px; right: 1rem; z-index: 9999;">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true" data-delay="3000">
        <div class="toast-header">
            <strong class="mr-auto">Toast Notification</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <!-- Toast message will be inserted here -->
        </div>
    </div>
</div>
