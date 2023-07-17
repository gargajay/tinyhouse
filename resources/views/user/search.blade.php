@extends('layouts.guest')
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
                                <li><a href="#" class="text-base textGray fw-600">All Categories</a></li>
                                <li><a href="#" class="text-base textGray fw-400">Tiny Houses</a></li>
                                <li><a href="#" class="text-base textGray fw-400">Deck Trailers</a></li>
                                <li><a href="#" class="text-base textGray fw-400">Tiny  House Trailers</a></li>
                                <li><a href="#" class="text-base textGray fw-400">Off-Grid</a></li>
                                <li><a href="#" class="text-base textGray fw-400">Loft Bedroom Models</a></li>
                                <li><a href="#" class="text-base textGray fw-400">Ground Level Bedroom Models</a></li>
                            </ul>
                            <div class="py-3">
                                <h4 class="text-lg mb-0 fw-600">Filters</h4>
                                <div class="border-bottom border-gray pt-4 pb-2">
                                    <div class="form-group">
                                        <h5 class="text-sm fw-600 textDark">Distance<span class="fw-400 ml-2">(50 Miles)</span></h5>
                                        <div class="d-flex align-items-center">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="text-sm fw-600 textDark">Year</h5>
                                        <select class="form-control">
                                            <option value="">Select Year</option>
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                            <option value="2018">2018</option>
                                            <option value="2017">2017</option>
                                            <option value="2016">2016</option>
                                            <option value="2015">2015</option>
                                            <option value="2014">2014</option>
                                            <option value="2013">2013</option>
                                            <option value="2012">2012</option>
                                            <option value="2011">2011</option>
                                            <option value="2010">2010</option>
                                            <option value="2009">2009</option>
                                            <option value="2008">2008</option>
                                            <option value="2007">2007</option>
                                            <option value="2006">2006</option>
                                            <option value="2005">2005</option>
                                            <option value="2004">2004</option>
                                            <option value="2003">2003</option>
                                            <option value="2002">2002</option>
                                            <option value="2001">2001</option>
                                            <option value="2000">2000</option>
                                            <option value="1999">1999</option>
                                            <option value="1998">1998</option>
                                            <option value="1997">1997</option>
                                            <option value="1996">1996</option>
                                            <option value="1995">1995</option>
                                            <option value="1994">1994</option>
                                            <option value="1993">1993</option>
                                            <option value="1992">1992</option>
                                            <option value="1991">1991</option>
                                            <option value="1990">1990</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="text-sm fw-600 textDark">Manufacture</h5>
                                        <select disabled="" class="form-control">
                                            <option value="">Select Manufacture</option>
                                            <option value="">M 1</option>
                                            <option value="">M 2</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="text-sm fw-600 textDark">Model</h5>
                                        <select disabled="" class="form-control">
                                            <option value="">Select Model</option>
                                            <option value="">Model 1</option>
                                            <option value="">Model 2</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="text-sm fw-600 textDark">Sleeps</h5>
                                        <select disabled="" class="form-control">
                                            <option value="">Select Sleep</option>
                                            <option value="">1 Adult</option>
                                            <option value="">2 Adult</option>
                                            <option value="">3 Adult</option>
                                            <option value="">4 Adult</option>
                                            
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="text-sm fw-600 textDark">Shower/Toielt</h5>
                                        <select class="form-control">
                                            <option value="">Yes</option>
                                            <option value="">No</option>
                                        </select
                                    </div>
                                    <div class="form-group">
                                        <h5 class="text-sm fw-600 textDark">Price Range</h5>
                                        <div class="d-flex align-items-center g-3">
                                            <input type="number" placeholder="Min" class="form-control">
                                            <p class="text-sm fw-400 textGray mb-0 mx-3">to</p>
                                            <input type="number" placeholder="Max" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-3">
                                    <h5 class="text-base fw-500">Condition</h5>
                                    <div class="condition_checkbox">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck11">
                                            <label class="custom-control-label" for="customCheck11">All</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                            <label class="custom-control-label" for="customCheck2">New</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck3">
                                            <label class="custom-control-label" for="customCheck3">Exellent</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck4">
                                            <label class="custom-control-label" for="customCheck4">Very Good</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck5">
                                            <label class="custom-control-label" for="customCheck5">Good</label>
                                        </div>
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
                                            <option value="mileage_lowest">Mileage: Lowest</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clear_filter text-right mb-3">
                                <a href="#" class="text-theme">Clear All Filter</a>
                            </div>

                            <ul class="houses_list column-6">
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img1.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img2.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img3.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img4.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img1.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img2.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img3.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img4.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img1.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img2.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img3.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img4.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img1.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img2.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img3.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img4.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img1.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img2.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img3.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="house_box">
                                        <a href="#" class="house_img">
                                            <img src="{{ asset('public/') }}/assets/images/house_img4.jpg" alt="House" class="img-fluid" />
                                        </a>
                                        <div class="house_content">
                                            <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">Deck Trailer</a></h3>
                                            <p class="h-price text-base fw-600 text-theme">$29,914</p>
                                            <p class="h-view text-sm fw-400 textGray">2 views</p>
                                            <p class="h-zip text-sm fw-400 textGray">Zip Code: 33064</p>
                                            <p class="h-post_date text-sm fw-400 textGray">Posted: 07-13-2023</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <nav aria-label="Page navigation example" class="pt-3">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <i class="fa fa-angle-left"></i>
                                        </a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection