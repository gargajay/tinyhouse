@extends('layouts.guest')
@section('content')
<div id="bodyWrapper" class="flex-grow-1">
    <section class="single_house_page pt-3 pb-5">
        <div class="container_lg py-17">
            <div class="single_house_inner">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="f-left">
                            <link rel="stylesheet" href="{{ asset('public/') }}/assets/css/slick.css" />
                            <link rel="stylesheet" href="{{ asset('public/') }}/assets/css/slick-theme.css" />
                            <div class="gallery mb-4 mb-xl-5">
                               
                                <div class="house_gallery">
                                    @if(isset($post->cars_images) && $post->cars_images->IsNotEmpty())
                                    @foreach($post->cars_images as $image)
                                    <div>
                                        <div class="house_img">
                                            <img src="{{ $image->image }}" alt="House" class="img-fluid" />
                                        </div>
                                    </div>
                                    @endforeach
                                   
                                    @endif
                                    
                                </div>
                                <div class="house_gallery_thumb">
                                @if(isset($post->cars_images) && $post->cars_images->IsNotEmpty())
                                    @foreach($post->cars_images as $image)
                                    <div>
                                        <div class="house_img">
                                            <img src="{{ $image->image }}" alt="House" class="img-fluid" />
                                        </div>
                                    </div>
                                    @endforeach
                                   
                                    @endif
                                  
                                </div>
                            </div>
                        </div>

                        <div class="hourse_right_dtl f-right">
                            <div class="title_head">
                                <h3 class="fw-600 textDark mb-0">{{$post->make}} {{$post->model}}</h3>
                                <p class="text-xl textDark fw-600 mt-1 mb-0">${{$post->make}}</p>
                                <p class="text-sm textDark fw-500 mt-1 mb-0">Post Code: 20015</p>
                            </div>
                            <div class="cusbtns py-4">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#sellerModal" class="btn btn-theme text-base fw-500 rounded-pill">Contact Seller</a>
                                <!-- <a href="javascript:void(0);" class="btn btn-danger text-base fw-500 rounded-pill">Sold</a> -->
                            </div>

                            <div class="house_dtl mt-4">
                                <h2 class="cusheading mb-0 text-xl font-weight-bold textDark text-uppercase">Details</h2>
                                <ul class="mt-4">
                                    <li>
                                        <span class="text-uppercase">Year</span>
                                        <span class="fw-500">{{$post->year}}</span>
                                    </li>
                                    <li>
                                        <span class="text-uppercase">Manufacture</span>
                                        <span class="fw-500">{{$post->make}}</span>
                                    </li>
                                    <li>
                                        <span class="text-uppercase">MODEL</span>
                                        <span class="fw-500">{{$post->model}}</span>
                                    </li>
                                    <li>
                                        <span class="text-uppercase">CONDITION</span>
                                        <span class="fw-500">{{$post->condition}}</span>
                                    </li>
                                    <li>
                                        <span class="text-uppercase">Shower/Toilet</span>
                                        <span class="fw-500">{{$post->mileage}}</span>
                                    </li>
                                 
                                    <li>
                                        <span class="text-uppercase">STATUS</span>
                                        <span class="fw-500">{{$post->title}}</span>
                                    </li>
                                    <!-- <li>
                                        <span class="text-uppercase">CAR FUEL TYPE</span>
                                        <span class="fw-500">Electric</span>
                                    </li> -->
                                    <li>
                                        <span class="text-uppercase">Sleeps</span>
                                        <span class="fw-500">{{$post->engine}}</span>
                                    </li>
                                    <li>
                                        <span class="text-uppercase">CITY</span>
                                        <span class="fw-500">{{$post->city}}</span>
                                    </li>
                                    <li>
                                        <span class="text-uppercase">STATE</span>
                                        <span class="fw-500">{{$post->state}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="f-left">
                            <!-- <div class="house_features">
                                <h2 class="text-xl font-weight-bold textDark text-uppercase mb-0">Features</h2>
                                <div class="inner_features py-4">
                                    <h4 class="text-lg fw-600">Convenience</h4>
                                    <ul class="pt-1">
                                        <li>Trailer towing technologies</li>
                                        <li>Selectable vehicle dynamics</li>
                                        <li>Massage seats</li>
                                        <li>Automatic climate control</li>
                                        <li>Phone as key</li>
                                        <li>Remote start</li>
                                        <li>Wheel locks</li>
                                        <li>Sunroof/moonroof</li>
                                        <li>Heated seats</li>
                                        <li>Leather seats</li>
                                        <li>Third row seating</li>
                                        <li>Memory seats</li>
                                        <li>Privacy windows</li>
                                        <li>Automatic adjustable seats</li>
                                        <li>Ventilated seats</li>
                                        <li>Off road technologies</li>
                                    </ul>
                                </div>

                                <div class="inner_features py-4">
                                    <h4 class="text-lg fw-600">Safety</h4>
                                    <ul class="pt-1">
                                        <li>Trailer towing technologies</li>
                                        <li>Selectable vehicle dynamics</li>
                                        <li>Massage seats</li>
                                        <li>Automatic climate control</li>
                                        <li>Phone as key</li>
                                        <li>Remote start</li>
                                        <li>Wheel locks</li>
                                        <li>Sunroof/moonroof</li>
                                        <li>Heated seats</li>
                                        <li>Leather seats</li>
                                        <li>Third row seating</li>
                                        <li>Memory seats</li>
                                        <li>Privacy windows</li>
                                        <li>Automatic adjustable seats</li>
                                        <li>Ventilated seats</li>
                                        <li>Off road technologies</li>
                                    </ul>
                                </div>

                                <div class="inner_features py-4">
                                    <h4 class="text-lg fw-600">Technology</h4>
                                    <ul class="pt-1">
                                        <li>Trailer towing technologies</li>
                                        <li>Selectable vehicle dynamics</li>
                                        <li>Massage seats</li>
                                        <li>Automatic climate control</li>
                                        <li>Phone as key</li>
                                        <li>Remote start</li>
                                        <li>Wheel locks</li>
                                        <li>Sunroof/moonroof</li>
                                        <li>Heated seats</li>
                                        <li>Leather seats</li>
                                        <li>Third row seating</li>
                                        <li>Memory seats</li>
                                        <li>Privacy windows</li>
                                        <li>Automatic adjustable seats</li>
                                        <li>Ventilated seats</li>
                                        <li>Off road technologies</li>
                                    </ul>
                                </div>
                            </div> -->

                            <div class="description mt-3 pt-5 border-top border-gray">
                                <h2 class="text-xl font-weight-bold textDark text-uppercase">Description</h2>
                                <p class="text-base textGray fw-400">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- contact Seller Modal -->
    <div class="modal fade cusmodal" id="sellerModal" tabindex="-1" aria-labelledby="sellerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-670">
            <div class="modal-content bg-none">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-xmark">
                            <path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                        </svg>
                    </button>
                    <div class="seller_dtl">
                        <div class="seller_profile_dtl text-center">
                            <div class="seller_img text-center mb-3">
                                <img src="https://pro.gocarhub.app/uploads/images/1685070449-image.png" alt="Seller Profile" class="img-fluid" />
                            </div>
                            <h3 class="fw-600 text-theme mb-0">Giancarlo caceres</h3>
                            <p class="text-base text-gray mb-0">N Federal Hwy, Pompano Beach, FL</p>

                            <div class="seller_btns pt-3">
                                <a href="#" class="btn btn-theme fw-500 rounded-pill mr-3">Call now</a>
                                <a href="#" class="btn btn-theme fw-500 rounded-pill">Message</a>
                            </div>
                        </div>
                        <div class="mt-10">
                            <h4 class="fw-500 text-xl border-bottom-4 border-theme px-3">Offers</h4>
                            <ul class="houses_list column-3">
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img1.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img2.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img3.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img4.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img1.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img2.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img3.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img4.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection