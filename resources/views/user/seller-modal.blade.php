<div class="modal-dialog modal-dialog-centered modal-670">
            <div class="modal-content bg-none">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-xmark">
                            <path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                        </svg>
                    </button>
                    <div class="seller_dtl">
                        <div class="seller_profile_dtl text-center">
                            <div class="seller_img text-center mb-3">
                                <img src="{{$seller->image}}" alt="Seller Profile" class="img-fluid" />
                            </div>
                            <h3 class="fw-600 text-theme mb-0">{{$seller->first_name}}  {{$seller->last_name}}</h3>
                            <p class="text-base text-gray mb-0">{{isset($seller->userAddress) ? $seller->userAddress->address_line1:"" }}</p>

                            <div class="seller_btns pt-3">
                                <a href="tel:{{$seller->mobile}}" class="btn btn-theme fw-500 rounded-pill mr-3">Call now</a>
                                <a href="mailto:{{$seller->email}}" class="btn btn-theme fw-500 rounded-pill">Email</a>
                            </div>
                        </div>
                        <div class="mt-10">
                            <h4 class="fw-500 text-xl border-bottom-4 border-theme px-3">Suppliers Listings</h4>
                            <ul class="houses_list column-3">
                            @if(!$cars->isEmpty())
                        @foreach($cars as $car)
                        <li class="item">
                            <div class="house_box">
                               
                                <a href="{{url('post-detail?id='.$car->id)}}" class="house_img">
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
                    </div>
                </div>
            </div>
        </div>