@extends('layouts.guest')
@section('content')
<div id="bodyWrapper" class="flex-grow-1">
    <div class="post_house_page pb-5">
        <div class="container_md py-17">
            <nav aria-label="breadcrumb" class="mt-0 pb-4 mt-lg-5 pb-lg-5">
                <ol class="breadcrumb p-0 bg-transparent">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Post a Tiny Home</li>
                </ol>
            </nav>
            <div class="post_house_inner">

                <div class="cusloader mb-5" style="display: none;">
                    <div class="cusloader_inner">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>

                <div class="accordion" id="accordionExample" style="display: block;">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span class="count">
                                    <span>1</span>
                                    <!-- <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-check "><path fill="currentColor" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path></svg> -->
                                </span>
                                <span>Photos</span>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="upload__box">
                                    <div class="upload__btn-box">
                                        <label class="upload__btn">
                                            <span class="d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-6 h-6 text-gray-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                </svg>
                                                <span class="fw-500 textDark">Drop files to Attach, or<span class="text-theme text-underline ml-2">browse</span></span>
                                            </span>
                                            <input type="file" multiple="" data-max_length="20" class="upload__inputfile">
                                        </label>
                                    </div>
                                    <div class="upload__img-wrap"></div>

                                    <div class="next_btn">
                                        <a href="javacscript:void(0);" class="btn btn-theme">Next</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span class="count">
                                    <span>2</span>
                                </span>
                                <span>Details</span>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="detail_inner">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Category <span>(optional)</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Select Category</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Condition <span>(optional)</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Select Condition</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Year</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Select Year</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Make</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Select Make</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Model</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Select Model</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Vehicle Trim <span>(optional)</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Select Vehicle Trim</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Mileage <span>(optional)</span></label>
                                            <input type="number" name="mileage" id="mileage" value="" placeholder="" class="form-control" />
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Car Fuel Type <span>(optional)</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Select Car Fuel Type</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Title Status <span>(optional)</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Select Title Status</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="next_btn">
                                    <a href="javacscript:void(0);" class="btn btn-theme">Next</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <span class="count">
                                    3
                                </span>
                                <span>Colors</span>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="select_colors mb-4">
                                    <div class="color_ext">
                                        <h3 class="text-lg fw-600 textDark mb-4">Exterior Color:</h3>
                                        <div class="color_list">
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color1">
                                                <label for="color1">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color2">
                                                <label for="color2">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color3">
                                                <label for="color3">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color4">
                                                <label for="color4">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color5">
                                                <label for="color5">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color6">
                                                <label for="color6">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color7">
                                                <label for="color7">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color8">
                                                <label for="color8">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color9">
                                                <label for="color9">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color10">
                                                <label for="color10">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color11">
                                                <label for="color11">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color12">
                                                <label for="color12">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color13">
                                                <label for="color13">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color14">
                                                <label for="color14">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color15">
                                                <label for="color15">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color16">
                                                <label for="color16">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="color" id="color17">
                                                <label for="color17">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="color_ext mt-4 pt-4 border-top border-gray">
                                        <h3 class="text-lg fw-600 textDark mb-4">Interior Color:</h3>
                                        <div class="color_list">
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color1">
                                                <label for="int_color1">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color2">
                                                <label for="int_color2">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color3">
                                                <label for="int_color3">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color4">
                                                <label for="int_color4">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color5">
                                                <label for="int_color5">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color6">
                                                <label for="int_color6">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color7">
                                                <label for="int_color7">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color8">
                                                <label for="int_color8">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color9">
                                                <label for="int_color9">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color10">
                                                <label for="int_color10">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color11">
                                                <label for="int_color11">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color12">
                                                <label for="int_color12">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color13">
                                                <label for="int_color13">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color14">
                                                <label for="int_color14">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color15">
                                                <label for="int_color15">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color16">
                                                <label for="int_color16">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="int_color" id="int_color17">
                                                <label for="int_color17">
                                                    <span style="background-color: aqua;"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="next_btn">
                                    <a href="javacscript:void(0);" class="btn btn-theme">Next</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <span class="count">
                                    4
                                </span>
                                <span>Features</span>
                            </h2>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="select_features mb-4 pb-3">
                                    <div class="inner_feature">
                                        <h3 class="text-lg fw-600 textDark mb-3">Convenience:</h3>
                                        <div class="inner_feature_list">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1">Trailer towing technologies</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                    <label class="custom-control-label" for="customCheck2">Selectable vehicle dynamics</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck3">
                                                    <label class="custom-control-label" for="customCheck3">Massage seats</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck4">
                                                    <label class="custom-control-label" for="customCheck4">Automatic climate control</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck5">
                                                    <label class="custom-control-label" for="customCheck5">Trailer towing technologies</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck6">
                                                    <label class="custom-control-label" for="customCheck6">Selectable vehicle dynamics</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck7">
                                                    <label class="custom-control-label" for="customCheck7">Massage seats</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck8">
                                                    <label class="custom-control-label" for="customCheck8">Automatic climate control</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inner_feature">
                                        <h3 class="text-lg fw-600 textDark mb-3">Safety:</h3>
                                        <div class="inner_feature_list">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1">Trailer towing technologies</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                    <label class="custom-control-label" for="customCheck2">Selectable vehicle dynamics</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck3">
                                                    <label class="custom-control-label" for="customCheck3">Massage seats</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck4">
                                                    <label class="custom-control-label" for="customCheck4">Automatic climate control</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck5">
                                                    <label class="custom-control-label" for="customCheck5">Trailer towing technologies</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck6">
                                                    <label class="custom-control-label" for="customCheck6">Selectable vehicle dynamics</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck7">
                                                    <label class="custom-control-label" for="customCheck7">Massage seats</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck8">
                                                    <label class="custom-control-label" for="customCheck8">Automatic climate control</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inner_feature">
                                        <h3 class="text-lg fw-600 textDark mb-3">Technology:</h3>
                                        <div class="inner_feature_list">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1">Trailer towing technologies</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                    <label class="custom-control-label" for="customCheck2">Selectable vehicle dynamics</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck3">
                                                    <label class="custom-control-label" for="customCheck3">Massage seats</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck4">
                                                    <label class="custom-control-label" for="customCheck4">Automatic climate control</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck5">
                                                    <label class="custom-control-label" for="customCheck5">Trailer towing technologies</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck6">
                                                    <label class="custom-control-label" for="customCheck6">Selectable vehicle dynamics</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck7">
                                                    <label class="custom-control-label" for="customCheck7">Massage seats</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck8">
                                                    <label class="custom-control-label" for="customCheck8">Automatic climate control</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="next_btn">
                                    <a href="javacscript:void(0);" class="btn btn-theme">Next</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFive">
                            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <span class="count">
                                    5
                                </span>
                                <span>Other Details</span>
                            </h2>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="other_detail mb-4">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <div class="inner_group">
                                            <span><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="dollar-sign" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-dollar-sign fa-solid text-gray-800">
                                                    <path fill="currentColor" d="M160 0c17.7 0 32 14.3 32 32V67.7c1.6 .2 3.1 .4 4.7 .7c.4 .1 .7 .1 1.1 .2l48 8.8c17.4 3.2 28.9 19.9 25.7 37.2s-19.9 28.9-37.2 25.7l-47.5-8.7c-31.3-4.6-58.9-1.5-78.3 6.2s-27.2 18.3-29 28.1c-2 10.7-.5 16.7 1.2 20.4c1.8 3.9 5.5 8.3 12.8 13.2c16.3 10.7 41.3 17.7 73.7 26.3l2.9 .8c28.6 7.6 63.6 16.8 89.6 33.8c14.2 9.3 27.6 21.9 35.9 39.5c8.5 17.9 10.3 37.9 6.4 59.2c-6.9 38-33.1 63.4-65.6 76.7c-13.7 5.6-28.6 9.2-44.4 11V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V445.1c-.4-.1-.9-.1-1.3-.2l-.2 0 0 0c-24.4-3.8-64.5-14.3-91.5-26.3c-16.1-7.2-23.4-26.1-16.2-42.2s26.1-23.4 42.2-16.2c20.9 9.3 55.3 18.5 75.2 21.6c31.9 4.7 58.2 2 76-5.3c16.9-6.9 24.6-16.9 26.8-28.9c1.9-10.6 .4-16.7-1.3-20.4c-1.9-4-5.6-8.4-13-13.3c-16.4-10.7-41.5-17.7-74-26.3l-2.8-.7 0 0C119.4 279.3 84.4 270 58.4 253c-14.2-9.3-27.5-22-35.8-39.6c-8.4-17.9-10.1-37.9-6.1-59.2C23.7 116 52.3 91.2 84.8 78.3c13.3-5.3 27.9-8.9 43.2-11V32c0-17.7 14.3-32 32-32z"></path>
                                                </svg></span>
                                            <input type="text" name="price" id="price" value="" placeholder="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Description <span>(optional)</span></label>
                                        <textarea name="description" id="description" placeholder="" rows="4" class="form-control" spellcheck="false"></textarea>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="findme">
                                        <label class="custom-control-label" for="findme">Find Me Buyer</label>
                                    </div>
                                </div>

                                <div class="next_btn">
                                    <a href="javacscript:void(0);" class="btn btn-theme">Next</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingSix">
                            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                <span class="count">
                                    6
                                </span>
                                <span>House Location</span>
                            </h2>
                        </div>
                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="other_detail mb-4">
                                    <div class="form-group">
                                        <label for="">Car Location</label>
                                        <div class="inner_group">
                                            <span><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-location-dot fa-solid text-gray-800">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg></span>
                                            <input type="text" name="location" id="location" value="" placeholder="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Zip Code</label>
                                        <input type="number" name="zip_code" id="zip_code" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="next_btn">
                                    <a href="javacscript:void(0);" class="btn btn-theme">Post</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success alert-theme alert-dismissible fade show" role="alert" style="display: none;">
                    House posted successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-xmark ">
                            <path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                        </svg>
                    </button>
                </div>

                <div class="text-center pt-5 mt-4 pb-3" style="display: none;">
                    <a href="/" class="btn btn-dark rounded py-3 px-5 text-base mr-2 mb-2">Go to home</a>
                    <a href="#" class="btn btn-theme rounded py-3 px-5 text-base mb-2">View Your Cars</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection