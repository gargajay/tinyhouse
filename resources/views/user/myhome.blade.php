@extends('layouts.guest')
@section('content')


<div id="bodyWrapper" class="flex-grow-1">
    <div class="account_page py-5">
        <div class="container_lg py-17">
            <div class="account_inner">
                <div class="leftbar">
                   @include('user.user-tab')
                </div>
                <div class="rightbar">
                    <div class="rightbar_inner">
                        <h2 class="page-heading text-2xl textDark font-weight-bold">My Tiny Homes</h2>
                        <div class="my_house p-10">
                            <ul class="houses_list column-6">
                                @forelse($cars as $car)
                                <li class="item">
                                    <div class="house_box">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary" data-toggle="dropdown" data-display="static" aria-expanded="false">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis-vertical" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512" class="svg-inline--fa fa-ellipsis-vertical">
                                                    <path fill="currentColor" d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"></path>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="javascript:void(0);" class="dropdown-item">Edit</a>
                                                <a href="javascript:void(0);" class="dropdown-item">Mark as Sold</a>
                                                <a href="javascript:void(0);" class="dropdown-item">Delete</a>
                                            </div>
                                        </div>
                                        <a href="#" class="house_img">
                                            <img src="{{$car->carImageSingle ? $car->carImageSingle->image:''}}" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">{{$car->make}} {{$car->model}}</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">{{$car->amount}}</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: {{$car->created_at->format('Y-m-d')}}</p>
                                            <a href="#" class="btn btn-theme d-block text-center text-sm w-100 px-4 py-2 mt-2">Send Enquiry</a>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                    <li>No House Found !</li>
                                @endforelse
                                
                              
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection