@extends('layouts.guest')
@section('page_style')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div id="bodyWrapper" class="flex-grow-1">
    <section class="search_page pt-3 pb-5">
        <div class="container_lg py-17">
            <div class="search_sec_inner">
                <div class="filter">
                    <a href="javascript:void(0);" class="close_filter d-xl-none">
                        <i class="fa fa-times"></i>
                    </a>
                    <ul class="categories border-bottom pb-3 border-gray">
                        <li><a href="#" class="text-base textGray fw-600 category-filter" data-category="">All Categories</a></li>
                        @forelse($categories as $listing)
                        <li><a href="#" class="text-base textGray fw-400 category-filter" data-category="{{$listing->id}}">{{$listing->title}}</a></li>
                        @empty
                        @endforelse
                    </ul>
                    <div class="py-3">
                        <h4 class="text-lg mb-0 fw-600">Filters</h4>
                        <div class="border-bottom border-gray pt-4 pb-2">
                            <div class="form-group">
                                <h5 class="text-sm fw-600 textDark">Distance<span class="fw-400 ml-2">(50 km)</span></h5>
                                <div class="d-flex align-items-center">

                                </div>
                            </div>
                            <div class="form-group">
                                <h5 class="text-sm fw-600 textDark">Year</h5>
                                <select name="year" class="form-control filter-input">
                                    <option value="">Select Year</option>
                                    @forelse($years as $listing)
                                    <option value="{{$listing->name}}">{{$listing->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <h5 class="text-sm fw-600 textDark">Manufacture</h5>
                                <select name="make" id="" class="form-control filter-input">
                                    <option value="">Select Manufacture</option>
                                    @forelse($makes as $listing)
                                    <option value="{{$listing->name}}">{{$listing->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <h5 class="text-sm fw-600 textDark">Model</h5>
                                <select name="model" id="" class="form-control filter-input">
                                    <option value="">Select model</option>
                                    @forelse($models as $listing)
                                    <option value="{{$listing->name}}">{{$listing->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group">
                                <h5 class="text-sm fw-600 textDark">Sleeps</h5>
                                <select name="engine_size" id="" class="form-control filter-input">
                                    <option value="">Select Sleeps</option>
                                    @forelse($sleeps as $listing)
                                    <option value="{{$listing->name}}">{{$listing->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group">
                                <h5 class="text-sm fw-600 textDark">Shower/Toielt</h5>
                                <select name="mileage" id="" class="form-control filter-input">
                                    <option value="">Select Shower/Toilet</option>
                                    @forelse($shower as $listing)
                                    <option value="{{$listing->name}}">{{$listing->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <h5 class="text-sm fw-600 textDark">Price Range</h5>
                                <div class="d-flex align-items-center g-3">
                                    <input type="number" id="minPrice" placeholder="Min" class="form-control">
                                    <p class="text-sm fw-400 textGray mb-0 mx-3">to</p>
                                    <input type="number" id="maxPrice" placeholder="Max" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="pt-3">
                            <h5 class="text-base fw-500">Condition</h5>
                            <div class="condition_checkbox">

                                @forelse($conditions as $listing)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="condition[]" class="custom-control-input filter-input" value="{{$listing->name}}" id="customCheck{{$listing->id}}">
                                    <label class="custom-control-label" for="customCheck{{$listing->id}}">{{$listing->name}}</label>
                                </div>
                                @empty
                                @endforelse


                            </div>
                        </div>

                        <div class="mobile_submit_btn d-xl-none pt-4">
                            <button class="btn btn-theme w-100 d-block text-base">See Listing</button>
                        </div>
                    </div>
                </div>
                <div class="result_box">
                    <div class="top_filter mb-3">
                        <h3 class="font-weight-bold textDark py-2"><span class="capitalize">All Categories</span></h3>
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="form-group mb-0 d-xl-none mr-4">
                                <a href="javascript:void(0);" class="show_filter">
                                    <i class="fa fa-sliders"></i> Filters
                                </a>
                            </div>
                            <div class="form-group mb-0">
                                <label for="sortby" class="fw-500">Sort by: </label>
                                <select name="sort" id="sortby" class="no-decor">
                                    <option value="recent_first">Recent First</option>
                                    <option value="closest_first">Closest First</option>
                                    <option value="price_lh">Price: Low to High</option>
                                    <option value="price_hl">Price: High to Low</option>
                                    <option value="model_newest">Model: Newest</option>
                                    <!-- <option value="mileage_lowest">Mileage: Lowest</option> -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="clear_filter text-right mb-3" id="clearFilters">
                        <a href="#" class="text-theme">Clear All Filter</a>
                    </div>
                    <!-- Loader element -->

                    <div id="loader" class="loader" style="display: none;">
                        <!-- <p>Loading search results...</p> -->
                    </div>
                    <div id="searchResults">

                    </div>




                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('page_script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Function to perform the AJAX request and update the search results
    function showLoader() {
        $('#loader').show();
    }

    // Function to hide the loader
    function hideLoader() {
        $('#loader').hide();
    }





    function clearFilters() {
        $('input[type="text"]').val(''); // Clear text inputs
        $('select').val(''); // Clear select inputs
    }

    function performAjaxRequest(formData) {
        showLoader(); // Show the loader when AJAX request starts

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var urlParams = new URLSearchParams(window.location.search);
        var queryParam = urlParams.get('search_term');
        var category_id = urlParams.get('category_id');
        if (queryParam) {
            formData.search_term = queryParam;
        }

        if (category_id) {
            formData.category_id = category_id;
        }


        var minPrice = parseInt($('#minPrice').val());
        var maxPrice = parseInt($('#maxPrice').val());

        // Check if both min and max prices are valid numbers
        if (!isNaN(minPrice) && !isNaN(maxPrice)) {
            // Create an object to hold the filter data
            formData.min_price = minPrice;
            formData.max_price = maxPrice;
        }

        var sort = $('#sortby').val();
        console.log(sort);


        if (sort) {
            formData.sort = sort;
        }

        var lat = localStorage.getItem('selected_location_lat') ?? '-28.016667' ;
        var lng = localStorage.getItem('selected_location_lng')  ??  '153.4';

        if (lat && lng) {
            formData.latitude = lat;
            formData.longitude = lng;
        }






        $.ajax({
            type: 'POST',
            url: '{{ url("/search2") }}',
            data: formData,
            success: function(response) {
                hideLoader(); // Hide the loader when AJAX request is successful
                $('#searchResults').html(response);
            },
            error: function() {
                hideLoader(); // Hide the loader on AJAX request error
                $('#searchResults').html('<p>Error occurred while processing the request.</p>');
            }
        });
    }
    jQuery(document).ready(function($) {
        // Function to show the loader





        // Initial AJAX request on page load
        performAjaxRequest({
            search_query: '',
            page: 1
        });

        // Handle form submission using delegated event handling
        $(document).on('submit', '#searchForm', function(event) {
            event.preventDefault();
            let formData = $(this).serialize();
            formData += '&page=1'; // Reset to the first page on new search
            performAjaxRequest(formData);
        });

        // Handle pagination link clicks using delegated event handling
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let pageUrl = $(this).attr('href');
            let page = pageUrl.split('page=')[1];
            var formData = gatherFilterData();
            formData.page = page;
            performAjaxRequest(formData);
        });
    });
</script>

</script>

<script>
    function gatherFilterData() {
        var filterData = {};
        $(".filter-input").each(function() {
            var input = $(this);
            var name = input.attr("name");
            var value = input.val();
            if (input.is(":checkbox")) {
                value = [];
                $("input[name='" + name + "']:checked").each(function() {
                    value.push($(this).val());
                });
            }
            filterData[name] = value;
        });
        // Category filter
        var selectedCategory = $(".category-filter.active").data("category");
        filterData.category_id = selectedCategory;
        return filterData;
    }


    $(document).ready(function() {
        // Function to gather filter data from active filter inputs


        // Event listener for applying filters
        $("#applyFilters").click(function() {
            var filterData = gatherFilterData();
            performAjaxRequest(filterData);
        });



        // Handle click on "Clear All Filter" link
        $('#clearFilters').on('click', function(event) {
            event.preventDefault();
            clearFilters();

            // Clear the category filter
            $('ul.categories a').removeClass('active');

            // Call the performAjaxRequest function with an empty search query and no filters
            performAjaxRequest({
                search_query: '',
                filters: {}
            });
        });

        // Event listener for changes in filter inputs
        $(".filter-input").change(function() {
            var filterData = gatherFilterData();
            performAjaxRequest(filterData);
        });

        $(".category-filter").click(function(e) {
            e.preventDefault();
            $(".category-filter").removeClass("active");
            $(this).addClass("active");
            var filterData = gatherFilterData();
            performAjaxRequest(filterData);
        });

        $('#sortby, input[name="search_term"]').on('change keyup', function() {
            var filterData = gatherFilterData();
            performAjaxRequest(filterData);
        });

        $('#minPrice, #maxPrice').on('input', function() {

            var filterData = gatherFilterData();
            performAjaxRequest(filterData);
        });
    });

    // Your performAjaxRequest function that takes the filter data as an argument
</script>
@endsection