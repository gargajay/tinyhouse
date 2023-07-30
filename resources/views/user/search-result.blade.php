<ul class="houses_list column-6" id="searchResults">

    @if(!$cars->IsEmpty())
    @foreach($cars as $car)
    <li class="item">
        <div class="house_box">
            <a href="{{url('post-detail?id='.$car->id)}}" class="house_img">
                <img src="{{ $car->carImageSingle ? $car->carImageSingle->image:'' }}" alt="House" class="img-fluid" />
            </a>
            <div class="house_content">
                <h3 class="title line-clamp-2 text-lg fw-600"><a href="#">{{$car->make }} {{$car->model }}</a></h3>
                <p class="h-price text-base fw-600 text-theme">${{$car->min_amount}} - ${{$car->amount}}</p>
                <p class="h-view text-sm fw-400 textGray">2 views</p>
                <p class="h-zip text-sm fw-400 textGray">Post Code: {{$car->zip_code}}</p>
                <p class="h-post_date text-sm fw-400 textGray">Posted: {{$car->created_at->format('Y-m-d')}}</p>
            </div>
        </div>
    </li>
    @endforeach
    @endif




</ul>

<nav aria-label="Page navigation example" class="pt-3">
    <ul class="pagination justify-content-center">

    {{ $cars->links() }}

        <!-- <li class="page-item">
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
        </li> -->
    </ul>
</nav>