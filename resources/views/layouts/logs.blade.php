<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>MindApp - Daily Logs</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/images/favicon.png') }}">
    <link href="{{ asset('admin/vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/vendor/chartist/css/chartist.min.css') }}">
    <link href="{{ asset('admin/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/bootstrap-confirm-delete.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
          integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
          crossorigin="anonymous"/>
    <link href="{{ asset('admin/css/admin_custom.css') }}" rel="stylesheet">

    @yield('page_style')
    <style>
        @media (min-width: 576px) {
            #bootstrap-confirm-dialog .modal-sm {
                max-width: 400px;
            }
        }

        #bootstrap-confirm-dialog .btn {
            padding: 10px 1.5rem;
        }
        @media only screen and (max-width : 1024px) {
            .chart-point {
                display: unset;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<!--*******************
    Preloader start
    ********************-->
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!--*******************
    Preloader end
    ********************-->

<!--**********************************
    Main wrapper start
    ***********************************-->
<div id="main-wrapper">

    @yield('content')

</div>
<!--**********************************
    Main wrapper end
    ***********************************-->

<!--**********************************
    Scripts
    ***********************************-->
<!-- Required vendors -->
<script src="{{ asset('admin/vendor/global/global.min.js') }}"></script>
<script src="{{ asset('admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('admin/vendor/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('admin/js/custom.min.js') }}"></script>
<script src="{{ asset('admin/js/deznav-init.js') }}"></script>

<!-- Datatable -->
<script src="{{ asset('admin/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>

<!-- Counter Up -->
<script src="{{ asset('admin/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('admin/vendor/jquery.counterup/jquery.counterup.min.js') }}"></script>

<!-- Apex Chart -->
{{--<script src="{{ asset('admin/vendor/apexchart/apexchart.js') }}"></script>--}}

<!-- Chart piety plugin files -->
<script src="{{ asset('admin/vendor/peity/jquery.peity.min.js') }}"></script>

<!-- Dashboard 1 -->
<script src="{{ asset('admin/js/dashboard/dashboard-1.js') }}"></script>
<script src="{{ asset('admin/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap-confirm-delete.js') }}"></script>
<script src="{{ asset('admin/js/jquery.shorten.min.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('admin/js/jquery.repeater.js') }}"></script>
<script src="{{ asset('admin/js/admin_custom.js') }}"></script>

@yield('page_script')
</body>
</html>
