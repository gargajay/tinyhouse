@extends('layouts.guest')
@section('content')
<div id="bodyWrapper" class="flex-grow-1">
<section class="home_filter pt-5 pb-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-11">
                            <div class="filter_box">
                                <form action="{{url('search')}}" method="get" >
                                <div class="top">
                                    <h3>Find your next house</h3>
                                    <!-- <ul>
                                        <li><a href="#" class="active">All</a></li>
                                        <li><a href="#" class="">New</a></li>
                                        <li><a href="#" class="">Used</a></li>
                                    </ul> -->
                                </div>
                                <div class="filter_form">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-lg-4">
                                        <select name="make" class="form-control filter-input">
                                                <option value="">Select Manufacture</option>
                                                @forelse($makes as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                        <select name="model" class="form-control filter-input">
                                                <option value="">Select Model</option>
                                                @forelse($models as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <select name="year" class="form-control filter-input">
                                                <option value="">Select Year</option>
                                                @forelse($years as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <div class="price">
                                            <input type="number" name="min_price" id="minPrice" placeholder="Min" class="form-control">
                                            <input type="number" name="max_price" placeholder="Max" class="form-control">

                                               
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <select name="engine_size" id="" class="form-control filter-input">
                                                <option value="">Select Sleeps</option>
                                                @forelse($sleeps as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <select name="mileage" id="" class="form-control filter-input">
                                                <option value="">Select Shower/Toilet</option>
                                                @forelse($shower as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="clear_btn">
                                        <a href="javascript:void(0);" onclick="clearFilters()">Clear All</a>
                                    </div>
                                </div>
            
                                <div class="show_btn">
                                    <button type="submit" >SHOW ME  TINY HOMES</button>
                                    <p class="mb-0">ALL THE TINY HOMES UNDER ONE ROOF</p>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="tinny_houses">
                <div class="container_lg py-17">
                    
                    <ul class="houses_list column-6">
                        @if(!$cars->isEmpty())
                        @foreach($cars as $car)
                        <li class="item">
                            <div class="house_box">
                                <a href="{{url('post-detail/?id='.$car->id)}}" class="house_img">
                                <img src="{{ $car->carImageSingle ? $car->carImageSingle->image:'' }}" alt="House" class="img-fluid" />
                                </a>
                                <div class="house_content">
                                    <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">{{$car->model}} {{$car->make}}</a></h3>
                                    <p class="h-price text-base fw-600 text-theme">${{$car->amount}}</p>
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