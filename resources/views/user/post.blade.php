@extends('layouts.guest')
@section('page_style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-dropdown {
        z-index: 2000; /* Adjust the z-index value as needed */
    }
</style>
@endsection

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
                <form action="" method="post" id="myForm" enctype="multipart/form-data">
                    @csrf
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
                                                <span class="fw-500 textDark"><span class="text-theme text-underline ml-2">browse</span></span>
                                            </span>
                                            <input type="file" multiple="" name="file[]" data-max_length="20" class="upload__inputfile">
                                        </label>
                                    </div>
                                    <div class="upload__img-wrap " id="imagePreview"></div>

                                    <div class="next_btn">
                                        <a href="javacscript:void(0);" id="nextBtn1" class="btn btn-theme">Next</a>
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
                                            <label for="">Category </label>
                                            <select name="category_id" id="category_id" class="form-control" required>
                                                <option value="">Select Category</option>
                                                @forelse($categories as $listing)
                                                <option value="{{$listing->id}}">{{$listing->title}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Condition </label>
                                            <select name="condition" id="condition" class="form-control">
                                                <option value="">Select Condition</option>
                                                @forelse($conditions as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Year</label>
                                            <select name="year" id="" class="form-control">
                                                <option value="">Select Year</option>
                                                @forelse($years as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group  cus_select col-md-6 col-lg-4">
                                            <label for="">Manufacture</label>
                                            <select name="make" id="makeSelect" class="form-control">
                                                <option value="">Select Manufacture</option>
                                                @forelse($makes as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Model</span></label>
                                            <select name="model" id="" class="form-control">
                                                <option value="">Select Model</option>
                                                @forelse($models as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Sleeps<span>(optional)</span></label>
                                            <select name="engine_size" id="" class="form-control">
                                                <option value="">Select Sleeps</option>
                                                @forelse($sleeps as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Shower/Toilet<span>(optional)</span></label>
                                            <select name="mileage" id="" class="form-control">
                                                <option value="">Select Shower/Toilet</option>
                                                @forelse($shower as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Kitchen appliances <span>(optional)</span></label>
                                            <select name="car_type" id="" class="form-control">
                                                <option value="">Select Kitchen appliances</option>
                                                @forelse($appliances as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Amount of windows <span>(optional)</span></label>
                                            <select name="title" id="" class="form-control">
                                                <option value="">Select windows</option>
                                                @forelse($windows as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse

                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Availability <span>(optional)</span></label>
                                            <select name="availability" id="" class="form-control">
                                                <option value="">Select Availability</option>
                                                @forelse($availability as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse

                                            </select>
                                        </div>

                                        <div class="form-group col-md-6 col-lg-4">
                                            <label for="">Frame Construction <span>(optional)</span></label>
                                            <select name="frame_construction" id="" class="form-control">
                                                <option value="">Select frame</option>
                                                @forelse($frame as $listing)
                                                <option value="{{$listing->name}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse

                                            </select>
                                        </div>


                                    </div>
                                </div>

                                <div class="next_btn">
                                    <a href="javacscript:void(0);" id="nextBtn2" class="btn btn-theme">Next</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header" id="headingFive">
                            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <span class="count">
                                    3
                                </span>
                                <span>Other Details</span>
                            </h2>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="other_detail mb-4">
                                    <div class="form-group">
                                        <label for="">Spend Budget</label>
                                        <div class="inner_group">
                                            <span><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="dollar-sign" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-dollar-sign fa-solid text-gray-800">
                                                    <path fill="currentColor" d="M160 0c17.7 0 32 14.3 32 32V67.7c1.6 .2 3.1 .4 4.7 .7c.4 .1 .7 .1 1.1 .2l48 8.8c17.4 3.2 28.9 19.9 25.7 37.2s-19.9 28.9-37.2 25.7l-47.5-8.7c-31.3-4.6-58.9-1.5-78.3 6.2s-27.2 18.3-29 28.1c-2 10.7-.5 16.7 1.2 20.4c1.8 3.9 5.5 8.3 12.8 13.2c16.3 10.7 41.3 17.7 73.7 26.3l2.9 .8c28.6 7.6 63.6 16.8 89.6 33.8c14.2 9.3 27.6 21.9 35.9 39.5c8.5 17.9 10.3 37.9 6.4 59.2c-6.9 38-33.1 63.4-65.6 76.7c-13.7 5.6-28.6 9.2-44.4 11V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V445.1c-.4-.1-.9-.1-1.3-.2l-.2 0 0 0c-24.4-3.8-64.5-14.3-91.5-26.3c-16.1-7.2-23.4-26.1-16.2-42.2s26.1-23.4 42.2-16.2c20.9 9.3 55.3 18.5 75.2 21.6c31.9 4.7 58.2 2 76-5.3c16.9-6.9 24.6-16.9 26.8-28.9c1.9-10.6 .4-16.7-1.3-20.4c-1.9-4-5.6-8.4-13-13.3c-16.4-10.7-41.5-17.7-74-26.3l-2.8-.7 0 0C119.4 279.3 84.4 270 58.4 253c-14.2-9.3-27.5-22-35.8-39.6c-8.4-17.9-10.1-37.9-6.1-59.2C23.7 116 52.3 91.2 84.8 78.3c13.3-5.3 27.9-8.9 43.2-11V32c0-17.7 14.3-32 32-32z"></path>
                                                </svg></span>
                                            <!-- <select name="amount" id="amount" class="form-control">
                                                <option value="">Select Budget</option>
                                                @forelse($budget as $listing)
                                                <option value="{{$listing->value}}">{{$listing->name}}</option>
                                                @empty
                                                @endforelse

                                            </select> -->

                                            <input type="text" name="amount" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Description <span>(optional)</span></label>
                                        <textarea name="description" id="description" placeholder="" rows="4" class="form-control" spellcheck="false"></textarea>
                                    </div>
                                    <!-- <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="findme">
                                        <label class="custom-control-label" for="findme">Find Me Buyer</label>
                                    </div> -->


                                </div>

                                <div class="next_btn">
                                    <a href="javacscript:void(0);" id="nextBtn3" class=" next_btn btn btn-theme">Next</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingSix">
                            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                <span class="count">
                                    4
                                </span>
                                <span>House Location</span>
                            </h2>
                        </div>
                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="other_detail mb-4">
                                    <div class="form-group">
                                        <label for="">Current Location</label>
                                        <div class="inner_group">
                                            <span><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-location-dot fa-solid text-gray-800">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg></span>
                                            <input type="text" name="car_address" id="locationInput" value="" placeholder="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Post Code</label>
                                        <input type="number" name="zip_code" id="zip_code" placeholder="" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="">National shipping</label>
                                        <select name="national_shipping" id="" class="form-control">
                                            <option value="">Select Shipping</option>
                                            @forelse($shipping as $listing)
                                            <option value="{{$listing->name}}">{{$listing->name}}</option>
                                            @empty
                                            @endforelse

                                        </select>
                                    </div>



                                </div>

                                <div class="next_btn">
                                    <a href="javacscript:void(0);" id="btnlast" class="btn btn-theme">Post</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>    
                </div>

                <!-- <div class="alert alert-success alert-theme alert-dismissible fade show" role="alert" style="display: none;">
                   <div id="msg">House posted successfully.</div> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-xmark ">
                            <path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                        </svg>
                    </button>
                </div> -->

                <div class="text-center pt-5 mt-4 pb-3" style="display: none;">
                    <a href="/" class="btn btn-dark rounded py-3 px-5 text-base mr-2 mb-2">Go to home</a>
                    <a href="#" class="btn btn-theme rounded py-3 px-5 text-base mb-2">View Your Cars</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')


<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#makeSelect').select2({
            tags: true, // Allow manually adding new options
            createTag: function(params) {
                // User has entered a new option, create a new tag for it
                return {
                    id: params.term,
                    text: params.term,
                    newOption: true // Add a custom property to identify new options
                };
            },
            insertTag: function(data, tag) {
                // Insert the new option into the list before the last option (the "Select Manufacture" option)
                data.push(tag);
            },
            // dropdownParent: $("#locationModal") // Set the parent element to avoid issues with modal z-index
        });
    });
</script>


<!-- JavaScript to handle "Next" button clicks -->
<script>
    $(document).ready(function() {

        

    // Call the function when you want to show the alert and buttons, e.g., on success
    

        // validate image

        // Track the previously selected files using an array
        let selectedFiles = [];

        // Handle file input change event
        $(".upload__inputfile").on("change", function() {
            // Combine newly selected files with previously selected files
            const newFiles = Array.from(this.files);
            selectedFiles = selectedFiles.concat(newFiles);

            // Show the total number of selected files (for debugging)
            console.log("Total selected files:", selectedFiles.length);

            // Call the validation function
            // if (validateFirstTab()) {
            //     $('#collapseOne').collapse('hide');
            //     $('#collapseTwo').collapse('show');
            // }
        });

        // Function to validate the first tab (Photos)

        // Initialize the accordion
        $('#accordionExample').on('show.bs.collapse', function(e) {
            $(e.target).prev('.card-header').addClass('active');
        }).on('hide.bs.collapse', function(e) {
            $(e.target).prev('.card-header').removeClass('active');
        });

        // Handle "Next" button click for the first tab
        $('#nextBtn1').on('click', function(e) {
            e.preventDefault();

            if (validateFirstTab()) {
                //   $('#collapseOne').collapse('hide');
                $('#collapseTwo').collapse('show');
            }
        });

        // Handle "Next" button click for the second tab
        $('#nextBtn2').on('click', function(e) {
            e.preventDefault();
            if (validateSecondTab()) {
                $('#collapseFive').collapse('show');
            }
        });

        // Handle "Next" button click for the third tab
        $('#nextBtn3').on('click', function(e) {
            e.preventDefault();
            if (validateThirdTab()) {
                $('#collapseSix').collapse('show');
            }
        });

        // Add validation functions for each tab (customize based on your form)

        function validateFirstTab() {
            // Check if at least 3 images are selected
            if (selectedFiles.length >= 3) {
                return true; // Validation passed, return true
            } else {
                // Display an error message or alert
                alert('Please select at least 3 images.');
                return false; // Validation failed, return false
            }
        }


        function validateSecondTab() {
            if ($('#category_id').val() === '') {
                // Display an error message or alert
                alert('Please select values for Category.');
                return false; // Validation failed, return false
            } else if ($('#condition').val() === '') {
                alert('Please select values for Condition.');
                return false; // Validation failed, return false
            } else {
                return true;
            }
        }

        function validateThirdTab() {
            if ($('#amount').val() === '') {
                // Display an error message or alert
                alert('Please select values for Budget.');
                return false; // Validation failed, return false
            } else {
                return true;
            }
        }
    });
</script>


<!-- code for image show -->

<script>
    jQuery(document).ready(function() {
        ImgUpload();
    });

    function ImgUpload() {
        var imgWrap = "";
        var imgArray = [];

        $('.upload__inputfile').each(function() {
            $(this).on('change', function(e) {
                imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                var maxLength = $(this).attr('data-max_length');

                var files = e.target.files;
                var filesArr = Array.prototype.slice.call(files);
                var iterator = 0;
                filesArr.forEach(function(f, index) {

                    if (!f.type.match('image.*')) {
                        return;
                    }

                    if (imgArray.length > maxLength) {
                        return false
                    } else {
                        var len = 0;
                        for (var i = 0; i < imgArray.length; i++) {
                            if (imgArray[i] !== undefined) {
                                len++;
                            }
                        }
                        if (len > maxLength) {
                            return false;
                        } else {
                            imgArray.push(f);

                            var reader = new FileReader();
                            reader.onload = function(e) {
                                var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                imgWrap.append(html);
                                iterator++;
                            }
                            reader.readAsDataURL(f);
                        }
                    }
                });
            });
        });

        $('body').on('click', ".upload__img-close", function(e) {
            var file = $(this).parent().data("file");
            for (var i = 0; i < imgArray.length; i++) {
                if (imgArray[i].name === file) {
                    imgArray.splice(i, 1);
                    break;
                }
            }
            $(this).parent().parent().remove();
        });
    }
</script>


<script>
jQuery(document).ready(function ($) {

    

    // Submit form Next button click
    $("#btnlast").on("click", function(e) {

      
        
      e.preventDefault();
      var form = $("#myForm")[0];
      var formData = new FormData(form);
      $(this).prop("disabled", true);
      // You can also add any additional data to the formData if needed
      // formData.append("some_key", "some_value");

    //   $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });

      // Submit the form using AJAX
      $.ajax({
        url: '{{url("/add-car")}}', // Replace with the URL where your form should be submitted
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          // Handle the success response here
        

       //   $("#msg").text(response.message);
       showToast(response.success, response.message);

       if(response.success){
        window.location.href = '{{url("buy-subscription?car_id=")}}' + response.car_id;

       }

      // var data = response.data;
          // You can redirect or display a success message
        },
        error: function(xhr, status, error) {

          // Handle the error response here
          console.error(error);
          // You can display an error message or handle the error accordingly
        }
      });
    });
  });
</script>











@endsection