@extends('layouts.guest')
@section('content')
<div id="bodyWrapper" class="flex-grow-1">
            <section class="tinny_houses">
                <div class="container_lg py-17">
                    <ul class="houses_list column-6">
                        @if(!$cars->isEmpty())
                        @foreach($cars as $car)
                        <li class="item">
                            <div class="house_box">
                                <a href="{{url('post-detail/?id='.$car->id)}}" class="house_img">
                                    <img src="{{ asset('public/') }}/assets/images/house_img1.jpg" alt="House" class="img-fluid" />
                                </a>
                                <div class="house_content">
                                    <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">{{$car->make}}</a></h3>
                                    <p class="h-price text-base fw-600 text-theme">${{$car->amount}}</p>
                                    <p class="h-view text-sm fw-400 textGray">2 views</p>
                                    <p class="h-zip text-sm fw-400 textGray">post Code: {{$car->zip_code}}</p>
                                    <p class="h-post_date text-sm fw-400 textGray">Posted: {{$car->created_at->format('Y-m-d')}}</p>
                                </div>
                            </div>
                        </li>
                        @endforeach
                        @endif
 
                    </ul>
                </div>
            </section>
        </div>
@endsection