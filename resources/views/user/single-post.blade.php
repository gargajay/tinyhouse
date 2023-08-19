@extends('layouts.guest')
@section('page_style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

@endsection
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
                               
                                <div class="house_gallery main-slider">
                                    @if(isset($post->cars_images) && $post->cars_images->IsNotEmpty())
                                    @foreach($post->cars_images as $image)
                                    <div>
                                        <div class="house_img slide " >
                                        <a href="{{ $image->image }}" class="popup-link">
                                            <img src="{{ $image->image }}" alt="House" class="img-fluid" />
                                        </a>
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
                                <p class="text-xl textDark fw-600 mt-1 mb-0">${{$post->amount}}</p>
                                <p class="text-sm textDark fw-500 mt-1 mb-0">Post Code: {{$post->zip_code}}</p>
                            </div>
                            <div class="cusbtns py-4">
                                <a href="javascript:void(0);" onclick="showSellerModal({{$post->user_id}})" class="btn btn-theme text-base fw-500 rounded-pill">Contact Seller</a>
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
                                        <span class="text-uppercase">Amount of windows</span>
                                        <span class="fw-500">{{$post->title_status}}</span>
                                    </li>
                                    
                                    <li>
                                        <span class="text-uppercase">Sleeps</span>
                                        <span class="fw-500">{{$post->engine_size}}</span>
                                    </li>
                                    <li>
                                        <span class="text-uppercase">Address</span>
                                        <span class="fw-500">{{$post->car_address}}</span>
                                    </li>
                                    <!-- <li>
                                        <span class="text-uppercase">CITY</span>
                                        <span class="fw-500">{{$post->city}}</span>
                                    </li>
                                    <li>
                                        <span class="text-uppercase">STATE</span>
                                        <span class="fw-500">{{$post->state}}</span>
                                    </li> -->
                                    <li>
                                        <span class="text-uppercase">Shower/Toilet</span>
                                        <span class="fw-500">{{$post->mileage}}</span>
                                    </li>
                                    <li>
                                        <span class="text-uppercase">Kitchen appliances </span>
                                        <span class="fw-500">{{$post->car_type}}</span>
                                    </li>
                                    <li>
                                        <span class="text-uppercase">Availability</span>
                                        <span class="fw-500">{{$post->availability}}</span>
                                    </li>
                                    <li>
                                        <span class="text-uppercase">Frame Construction</span>
                                        <span class="fw-500">{{$post->frame_construction}}</span>
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
                                <p class="text-base textGray fw-400">{!! $post->description !!}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- contact Seller Modal -->
    <div class="modal fade cusmodal" id="sellerModal" tabindex="-1" aria-labelledby="sellerModalLabel" aria-hidden="true">
        
    </div>
</div>


@section('page_script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>
// $('.house_gallery').on('click', '.slick-slide', function() {
//     var largeImageUrl = $(this).find('img').attr('src');
    
//     $.magnificPopup.open({
//         items: [
//             { src: largeImageUrl }
//         ],
//         gallery: {
//             enabled: true, // Enable gallery mode
//             navigateByImgClick: false, // Prevent closing on image click
//             preload: [1, 1] // Preload one next and one previous image
//         },
//         type: 'image',
//         removalDelay: 300, // Delay removal to allow prev/next links to fade in
//         mainClass: 'mfp-fade',
//         arrowMarkup:
//             '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%" style="border:solid;1px;red;"></button>',
//         tPrev: 'Previous', // Text for previous button
//         tNext: 'Next' // Text for next button
//         // Add more Magnific Popup options here if needed
//     });
// });
$('.popup-link').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        },
        mainClass: 'mfp-with-zoom', // Add this line for zoom effect
        zoom: {
            enabled: true,
            duration: 300,
            opener: function(element) {
                return element.find('img');
            }
        }
    });


</script>
@endsection


@endsection