@extends('layouts.admin.admin')
@section('content')
    <!-- Main content -->
    <div class="content-wrapper">
        <div class="content-inner">
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-lg-inline">
                    <div class="page-title d-flex">
                        <h4> <span class="font-weight-semibold">{{ $data['page_title'] ?? 'Seller Car Detail' }}</span></h4>
                        <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
                    </div>
                    <div class="header-elements d-none">
                        <div class="d-flex justify-content-center">
                            @php
                                echo '<pre></pre>';
                                
                            @endphp
                            <a href="{{ route('seller-user.show', [$data['user_id']]) }}" type="button"
                                class="btn btn-primary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                @include('success-error')
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Vehicle
                                            Name:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['make'] ?? '' }}" />
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 col-form-label"></div>
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Vehicle
                                            Model:</strong></label>
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['model'] ?? '' }}" />
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Manufacture
                                            Year:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['year'] ?? '' }}" />
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 col-form-label"></div>
                                    <label
                                        class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Amount:</strong></label>
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-form-label">
                                        <input type="text" readonly class="form-control" id="videos"
                                            value="{{ $data['amount'] ?? '' }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Engine
                                            Size:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['engine_size'] ?? '' }} " />
                                    </div>

                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 col-form-label"></div>
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Car
                                            Type:</strong></label>
                                    <div class="input-group col-sm-4 col-md-4 col-lg-4 col-xl-4 col-form-label">

                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['car_type'] ?? '' }}" />

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Find Me
                                            Buyer:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['find_me_buyer'] == true ? 'Active' : 'Inactive'  }}" />
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 col-form-label"></div>
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Expiry
                                            Date:</strong></label>
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['expiry_date'] ?? '' }}" />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label
                                        class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Subscription:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['is_subscription'] == true ? 'Active' : 'Inactive' }}" />
                                       
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 col-form-label"></div>
                                    <label
                                        class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Contact:</strong></label>
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['is_contact'] == true ? 'Active' : 'Inactive' }}" />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label
                                        class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Payment:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['is_payment'] == true ? 'Active' : 'Inactive'  }}" />
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 col-form-label"></div>
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Registration
                                            Number:</strong></label>
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['registration_number'] ?? '' }}" />
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Engine
                                            Number:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['engine_number'] ?? '' }}" />
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 col-form-label"></div>
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Meter
                                            Reading:</strong></label>
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['meter_reading'] ?? '' }}" />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Car Fuel
                                            Type:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['car_fuel_type'] ?? '' }}" />
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 col-form-label"></div>
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Car Plate
                                            Number:</strong></label>
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['car_number_plate'] ?? '' }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Post Ad
                                            Number:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['post_ad_number'] ?? '' }}" />
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 col-form-label"></div>
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Car Plate
                                            Number:</strong></label>
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['car_number_plate'] ?? '' }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Description:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <textarea name="description" class="form-control form-control-lg" placeholder="Please enter service description"
                                            rows="8" readonly>{{ $data['description'] ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label
                                        class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Image:</strong></label>
                                    <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 col-form-label">
                                        @foreach ($data['cars_images'] ?? [] as $image)
                                            <div class="d-inline-block mb-3">

                                                <img class="img-fluid" src="{{ $image['image'] ?? '' }}"
                                                    height="200px"width="200px">
                                                <div class="card-img-actions-overlay card-img rounded-circle">
                                                    <a href="#"
                                                        class="btn btn-outline-white border-2 btn-icon rounded-pill">
                                                        <i class="icon-pencil"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
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
@section('page_script')
@endsection
@section('page_style')
    <style>
        .popular-items-chart-wrapper {
            width: 50%;
            float: left;
        }

        .form-group {
            margin-bottom: 0px;
        }
    </style>
@endsection
