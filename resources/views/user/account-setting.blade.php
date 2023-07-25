@extends('layouts.guest')

@section('content')
@php
$user = Auth::user();
@endphp
<div id="bodyWrapper" class="flex-grow-1">
            <div class="account_page py-5">
                <div class="container_lg py-17">
                    <div class="account_inner">
                        <div class="leftbar">
                        @include('user.user-tab')

                        </div>
                        <div class="rightbar">
                            <div class="rightbar_inner">
                                <h2 class="page-heading text-2xl textDark font-weight-bold">Account Settings</h2>
                                <div class="account_setting p-10">
                                    <div class="account_profile d-flex justify-content-between align-items-center">
                                        <div class="account_info">
                                            <div class="account_img">
                                                <img src="{{$user->image}}" alt="User" class="img-fluid" />
                                            </div>
                                            <div class="account_info_inner">
                                                <h3 class="text-2xl fw-600 textDark mb-0">{{$user->name}}</h3>
                                                <p class="desc text-base textDark mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Id aliquam officiis aut consequatur vero alias nisi culpa accusantium nemo dolor, quaerat ipsam hic tempora laboriosam commodi tempore laborum harum autem.</p>
                                                <div class="review mt-3 d-inline-flex align-items-center">
                                                    <span class="text-sm bg-theme text-white rounded-pill px-2 py-1 bg-theme mr-3">
                                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-star mr-0"><path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>
                                                        <span>0.0</span>
                                                    </span>
                                                    <p class="text-base textDark mb-0">0 Reviews</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="account_edit text-right">
                                            <div><button type="button" data-toggle="modal" data-target="#profileEditModal" class="text-base fw-500 btn btn-theme px-4 rounded-pill">Edit Profile</button></div>
                                            <div><button type="button" class="rounded-pill bg-transparent border-0 py-2 text-danger text-underline mt-4">Delete Account</button></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile Edit Modal -->
                                <div class="modal fade cusmodal" id="profileEditModal" tabindex="-1" aria-labelledby="profileEditModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-670">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-xmark"><path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path></svg>
                                                </button>
                                                <div>
                                                    <div class="logo text-center mb-2">
                                                        <img src="assets/images/logo.png" alt="logo" class="img-fluid" />
                                                    </div>
                                                    <div class="mt-10 w-100">
                                                        <div class="form-group upload_profile_img pb-5">
                                                            <img src="https://pro.gocarhub.app/uploads/images/1689246233-product_img_hover1.webp" alt="Profile" class="aspect-square mx-auto rounded-pill" />
                                                            <input type="file" name="image" id="upload_img" class="hidden">
                                                            <label for="upload_img" class="edit_img">
                                                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-pen-to-square "><path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path></svg>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <input type="text" placeholder="First name" value="Rajat" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <input type="text" placeholder="Last name" value="Bansal" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="email" placeholder="Email" value="rk891811@gmail.com" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="tel" placeholder="Phone Number" value="98756542321" class="rounded-pill bg-transparent backdrop-blur border text-white w-100 py-3 px-4" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea name="" id="" rows="4" placeholder="Bio" value="Lorem ipsum dolor sit amet" class="bg-transparent backdrop-blur border text-white w-100 py-3 px-4 rounded-4"></textarea>
                                                        </div>
                                                        <button type="button" class="btn-light fw-600 w-100 mt-3">Update Profile</button>
                                                    </div>
                                                </div>
                                            </div>
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