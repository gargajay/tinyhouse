@extends('layouts.admin.admin')
@section('content')
    <!-- Main content -->
    <div class="content-wrapper">
        <div class="content-inner">
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-lg-inline">
                    <div class="page-title d-flex">
                        <h4> <span class="font-weight-semibold">{{ $data['page_title'] ?? 'Seller User Detail' }}</span></h4>
                        <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
                    </div>
                    <div class="header-elements d-none">
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('seller-user') }}" type="button" class="btn btn-primary">Back</a>
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
                                    <label class="col-lg-3 col-form-label"><strong>Name:</strong></label>
                                    <div class="col-lg-9 col-form-label">
                                        {{ $data['first_name'] ?? '' }} {{ $data['last_name'] ?? '' }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><strong>Email:</strong></label>
                                    <div class="col-lg-9 col-form-label">
                                        {{ $data['email'] ?? '' }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><strong>Mobile:</strong></label>
                                    <div class="col-lg-9 col-form-label">
                                        {{ $data['country_code'] ?? '' }}{{ $data['mobile'] ?? '' }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><strong>Image:</strong></label>
                                    <div class="col-lg-9 col-form-label">
                                        <div class="d-inline-block mb-3">
                                            <img class="img-fluid" src="{{ $data['image'] ?? '' }}" width="150"
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

                                {{-- <div class="card"> --}}
                                <div class="table-responsive">
                                    <table class="table my-datatable">
                                        <thead class="t-head">
                                            <tr class="">
                                                <th>#</th>
                                                <th>Vehicle Company</th>
                                                <th>Vehicle Model</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if (count($result) > 0)
                                                <?php $firstItemIndex = $result->firstItem(); ?>

                                                @foreach ($result as $key => $value)
                                                    <tr>
                
                                                        <td>{{ $firstItemIndex++ }}</td>
                                                        <td>{{ $value->make ?? '' }}</td>
                                                        <td>{{ $value->model ?? '' }}</td>
                                                        <td>
                                                            <div class="list-icons">
                                                                <div class="dropdown">
                                                                    <a href="#"
                                                                        class="list-icons-item dropdown-toggle"
                                                                        data-toggle="dropdown"><i class="icon-cog6"></i></a>

                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a href="{{ route('seller-car-detail.sellerCarDetails', [$value->id]) }}"
                                                                            class="dropdown-item"><i
                                                                                class="icon-eye"></i>Detail</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                        <tfoot class="datatable">
                                            <tr>
                                                <td class="text" colspan="8">
                                                    <?php echo 'Showing ' . $result->firstItem() . ' to ' . $result->lastItem() . ' out of ' . $result->total() . ' entries'; ?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="5">No Record Found</td>
                                        </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div style="float: right;">
                            {{ $result->links() }}
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
