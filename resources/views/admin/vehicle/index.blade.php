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
                            <a href="{{ route('vehicle.create') }}" type="button" class="btn btn-primary">Add</a>
                            <form style="margin-left: 5px;" action="{{ route('vehicle.index') }}">
                                <div class="navbar-search d-flex align-items-center py-2 py-lg-0">
                                    <div class="form-group-feedback form-group-feedback-left flex-grow-1">
                                        <input type="search" name="q" class="form-control my-search-box"
                                            placeholder="Search" value="{{ $data['q'] ?? '' }}">
                                        <button type="submit" id="search-btn-my" class="btn btn-primary"><i
                                                class="icon-search4 fa fa-fw"></i></button>
                                        <div class="form-control-feedback">
                                            <i class="icon-search4 opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                @include('success-error')
                <div class="card">
                    <div class="table-responsive">
                        <table class="table my-datatable">
                            <thead class="t-head">
                                <tr class="">
                                    <th>#</th>
                                    <th>Vehicle Company</th>
                                    {{-- <th>Vehicle Model</th> --}}
                                    {{-- <th>Manufacture Year</th>
                                    <th>Amount</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($result) > 0)
                                    <?php $firstItemIndex = $result->firstItem(); ?>
                                    @foreach ($result as $key => $value)
                                        <tr>
                                            <td>{{ $firstItemIndex++ }}</td>
                                            <td>{{ $value['vehicle_name'] ?? '' }}</td>
                                            {{-- <td>{{ $value['model_name'] ?? '' }}</td> --}}
                                            <td>
                                                <div class="list-icons">
                                                    <a href="{{ route('vehicle.edit', [$value['id']]) }}"
                                                        class="list-icons-item text-primary" title="Edit"><i
                                                            class="icon-pencil7"></i></a>
                                                    {{-- <a href="#" title="Delete" class="list-icons-item text-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $value->id ,$value->title }}">
                                                                <i class="icon-trash"></i></a> --}}
                                                    <a href="{{ route('vehicle.delete', [$value['id']]) }}"
                                                        class="list-icons-item text-danger" title="Delete"><i
                                                            class="icon-trash"></i></a>
                                                    <a href="{{ route('vehicle-model.index', ['cid' => $value['id']]) }}"
                                                        class="list-icons-item text-primary" title="vehicle-model"><i
                                                            class="icon-database-menu"></i></a>
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
                <div style="float: right;">
                    {{ $result->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
