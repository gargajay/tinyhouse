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
                            <a href="{{ route('category.create') }}" type="button" class="btn btn-primary">Add</a>
                            <form style="margin-left: 5px;" action="{{ route('category.index') }}">
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
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($result) > 0)
                                    <?php $firstItemIndex = $result->firstItem(); ?>
                                    @foreach ($result as $key => $value)
                                        <tr>
                                            <td>{{ $firstItemIndex++ }}</td>
                                            <td>{{ $value['title'] ?? '' }}</td>
                                            <td>
                                                <div class="list-icons">
                                                    <a href="{{ route('category.edit', [$value['id']]) }}"
                                                        class="list-icons-item text-primary" title="Edit"><i
                                                            class="icon-pencil7"></i></a>
                                                      <a href="#" title="Delete" class="list-icons-item text-danger" data-toggle="modal" data-target="#exampleModal{{$value->id}}">
                                                                <i class="icon-trash"></i></a> 
                                                    <!-- <a href="{{ route('sub-category.index', ['cid' => $value['id']]) }}"
                                                        class="list-icons-item text-primary" title="Sub-categories"><i
                                                            class="icon-database-menu"></i></a> -->
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="exampleModal{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                           <div class="modal-content">
                                          <div class="modal-body">
                                              Are you sure you want to delete?  {{ $value->title ?? '' }}
                                        </div>
                                        <div class="modal-footer">
                                      <form action="{{ route('category.delete', [$value['id']]) }}" method="GET">
                                       @csrf
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                     <button class="btn btn-primary" type="submit" id="btn-save">Delete</button>
                                  </form>
                                  </div>
                                 </div>
                                 </div>
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
                                <td class="text-center" colspan="3">No Record Found</td>
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
</div>
@endsection
@section('page_script')
    <script>
        $(document).ready(function() {
            $(".resource-status").on("change", function() {
                const resource_id = $(this).attr('data-id');
                const is_checked = $(this).is(":checked");
                let status = '0';
                if (is_checked) {
                    status = '1';
                }
                $.ajax({
                    url: "{{ route('update.user.status') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        resource_id: resource_id,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {

                    },
                    error: function(error) {

                    }
                });
            });
        });
    </script>
@endsection
@section('page_style')
    <style>
        .popular-items-chart-wrapper {
            width: 50%;
            float: left;
        }
    </style>
@endsection
