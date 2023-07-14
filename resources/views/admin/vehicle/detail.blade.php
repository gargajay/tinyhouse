@extends('layouts.admin.admin')
@section('content')
    <!-- Main content -->
    <div class="content-wrapper">
        <div class="content-inner">
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-lg-inline">
                    <div class="page-title d-flex">
                        <h4> <span class="font-weight-semibold">{{ $data['page_title'] ?? 'Dashboard' }}</span></h4>
                        <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
                    </div>
                    <div class="header-elements d-none">
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('vehicle.index') }}" type="button" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                @include('success-error')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Vehicle
                                            Company:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['VehicleCompany']['vehicle_name'] ?? '' }}" />
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 col-form-label"></div>
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Vehicle
                                            Model:</strong></label>
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['model_name'] ?? '' }}" />
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Manufactured
                                            Year:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <input type="text" readonly class="form-control" id="staticEmail"
                                            value="{{ $data['email'] ?? '' }}" />
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 col-form-label"></div>
                                    <label
                                        class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Amount:</strong></label>
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-form-label">
                                        <input type="text" readonly class="form-control" id="videos" value="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-form-label"><strong>Image:</strong></label>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-form-label">
                                        <div class="d-inline-block mb-3">
                                            <img class="img-fluid" src="{{ $data['image'] ?? asset('images/151962.svg') }}" width="150"
                                                height="150" alt="">
                                            <div class="card-img-actions-overlay card-img rounded-circle">
                                                <a href="#"
                                                    class="btn btn-outline-white border-2 btn-icon rounded-pill">
                                                    <i class="icon-pencil"></i>
                                                </a>
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
