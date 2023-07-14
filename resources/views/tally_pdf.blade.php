<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="content-wrapper">
        <div class="content-inner">
            <div class="content">
                <div style="width:70%;margin:auto;">
                    <div class="">
                        <div class="col-lg-6">
                            <div class="p-3">

                                <b>{{$tallyData->company_name}}</b>

                                <hr />

                                <p>Address - {{$tallyData->address}} {{$tallyData->city}}


                                <p>Well Number - {{$tallyData->well_number}}</p>

                                <p>County - {{$tallyData->country}} State - {{$tallyData->state}}</p>

                            </div>

                            <div class="table-responsive">
                                <table class="table my-datatable text-center table-bordered">
                                    <thead class="t-head">
                                        <tr class="">
                                            <th>Jts</th>
                                            <th>Length</th>
                                            <th>Out</th>
                                            <th>Total Run</th>
                                        </tr>
                                    </thead>
                                    @if (count($calculations) > 0)
                                    <tbody>
                                        @php($total=0)
                                        @foreach ($calculations as $key => $value)
                                        <tr>
                                            <td>{{ $value['jts'] }}</td>
                                            <td>{{ $value['length'] ?? '' }}</td>
                                            <td>{{ $value['out'] ?? '' }}</td>
                                            <td>{{ $value['total'] ?? '' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="datatable">
                                        <tr>
                                            <td class="text-right" colspan="3">Total Run - </td>
                                            <td class="text-center">{{$totalPrice}}</td>
                                        </tr>
                                    </tfoot>
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="8">No Record Found</td>
                                    </tr>
                                    @endif

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>