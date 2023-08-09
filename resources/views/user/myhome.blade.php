@extends('layouts.guest')
@section('page_style')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
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
                                            @php
                                                $deleteUrl = url('delete-car');
                                                $redUrl = url('my-home');
                                                $markUrl = url('mark-sold');
                                            @endphp
                                                <!-- <a href="javascript:void(0);" class="dropdown-item">Edit</a> -->
                                                <a href="javascript:void(0);" onclick="actionItem('{{$markUrl}}','{{$redUrl}}','{{$car->id}}')" class="dropdown-item">Mark as Sold</a>
                                               
                                                <a href="javascript:void(0);" onclick="actionItem('{{$deleteUrl}}','{{$redUrl}}','{{$car->id}}')" class="dropdown-item">Delete</a>
                                                <a href="{{url('buy-subscription?car_id='.$car->id)}}" class="dropdown-item">Manage subscription</a>


                                            </div>
                                        </div>
                                        <a href="#" class="house_img">
                                            <img src="{{$car->carImageSingle ? $car->carImageSingle->image:''}}" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">{{$car->make}} {{$car->model}}</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">${{$car->amount}}</p>
                                            <!-- <p class="h-view text-sm fw-400 textGray">2 views</p> -->
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: {{$car->created_at->format('Y-m-d')}}</p>
                                            <a href="#" class="btn btn-theme d-block text-center text-sm w-100 px-4 py-2 mt-2">{{$car->sold_at ? 'Sold':'Unsold' }}</a>
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

@section('page_script')

<script>

    

    // Submit form Next button click

    function actionItem(url, redirectUrl, id) {
    if (confirm("Are you sure you want to make this action")) {
        var formData = new FormData();
        formData.append("car_id", id);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                showToast(response.success, response.message);
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
}

    // function deleteCar(id){
    //   var formData = new FormData();
    //   formData.append("car_id", id);
    //   $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //   $.ajax({
    //     url: '{{url("/delete-car")}}', // Replace with the URL where your form should be submitted
    //     method: "POST",
    //     data: formData,
    //     processData: false,
    //     contentType: false,
    //     success: function(response) {
    //    showToast(response.success, response.message);
    //    window.location.href = '{{url("my-home")}}';
    //     },
    //     error: function(xhr, status, error) {
    //       console.error(error);
    //     }
    //   });
    // }
    

      
  
</script>

@endsection