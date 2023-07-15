@extends('layouts.admin.admin')
@section('content')
    <!-- Main content -->
    <div class="content-wrapper">
        <div class="content-inner">
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-lg-inline">
                    <div class="page-title d-flex">
                        <h4> <span class="font-weight-semibold">Dashboard</span></h4>
                        <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="row">

                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <div class="card card-body card-box text-white has-bg-image">
                            <div class="media">
                                <div class="media-body">
                                    <h3 class="mb-0">{{ $data['seller_count'] ?? 0 }}</h3>
                                    <span class="text-uppercase font-size-xs">Sellers</span>
                                </div>
                                <div class="ml-3 align-self-center">
                                    <i class="icon-users2 icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <div class="card card-body card-box text-white has-bg-image">
                            <div class="media">
                                <div class="media-body">
                                    <h3 class="mb-0">{{ $data['buyer_count'] ?? 0 }}</h3>
                                    <span class="text-uppercase font-size-xs">Buyers</span>
                                </div>
                                <div class="ml-3 align-self-center">
                                    <i class="icon-users2 icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <div class="card card-body card-box text-white has-bg-image">
                            <div class="media">
                                <div class="media-body">
                                    <h3 class="mb-0">{{ $data['car_count'] ?? 0 }}</h3>
                                    <span class="text-uppercase font-size-xs">Cars</span>
                                </div>
                                <div class="ml-3 align-self-center">
                                    <i class="icon-car icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Sellers</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="seller-graph"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Buyers</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="buyer-graph"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Cars</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="car-graph"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_script')
    <script>
        // USER GRAPH : STAR
        let userMonthlyData = '<?php echo json_encode($monthlyCarData); ?>';
        userMonthlyData = JSON.parse(userMonthlyData);

        let userGraphLabels = [];
        let userGraphData = [];

        userMonthlyData.map((value, index) => {
            userGraphLabels.push(value.month);
            userGraphData.push(value.total);
        });

        const userData = {
            labels: userGraphLabels,
            datasets: [{
                label: '',
                data: userGraphData,
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    '#4e8c95',
                    '#cc8683',
                    '#6c953d',
                    '#3d647a',
                    '#1e74ae',
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    '#4e8c95',
                    '#cc8683',
                    '#6c953d',
                    '#3d647a',
                    '#1e74ae',
                ],
                borderWidth: 1
            }]
        };

        const userGraphConfig = {
            type: 'bar',
            data: userData,
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        type: 'logarithmic',
                        grid: {
                            display: false
                        },
                        ticks: {
                            // forces step size to be 50 units
                            stepSize: 10
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            boxWidth: 0
                        }
                    }
                },
            },
        };

        var userGraph = new Chart(
            document.getElementById('car-graph'),
            userGraphConfig
        );
        // USER GRAPH : ENS
    </script>

    <script>
        // USER GRAPH : STAR
        let trainerMonthlyData = '<?php echo json_encode($monthlySellerData); ?>';
        trainerMonthlyData = JSON.parse(trainerMonthlyData);

        let trainerGraphLabels = [];
        let trainerGraphData = [];

        trainerMonthlyData.map((value, index) => {
            trainerGraphLabels.push(value.month);
            trainerGraphData.push(value.total);
        });

        const trainerData = {
            labels: trainerGraphLabels,
            datasets: [{
                label: '',
                data: trainerGraphData,
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    '#4e8c95',
                    '#cc8683',
                    '#6c953d',
                    '#3d647a',
                    '#1e74ae',
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    '#4e8c95',
                    '#cc8683',
                    '#6c953d',
                    '#3d647a',
                    '#1e74ae',
                ],
                borderWidth: 1
            }]
        };

        const trainerGraphConfig = {
            type: 'bar',
            data: trainerData,
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            // forces step size to be 50 units
                            stepSize: 10
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            boxWidth: 0
                        }
                    }
                },
            },
        };

        var trainerGraph = new Chart(
            document.getElementById('seller-graph'),
            trainerGraphConfig
        );
        // USER GRAPH : ENS
    </script>

    <script>
        // USER GRAPH : STAR
        let gymMonthlyData = '<?php echo json_encode($monthlyBuyerData); ?>';
        gymMonthlyData = JSON.parse(gymMonthlyData);

        let gymGraphLabels = [];
        let gymGraphData = [];

        gymMonthlyData.map((value, index) => {
            gymGraphLabels.push(value.month);
            gymGraphData.push(value.total);
        });

        const gymData = {
            labels: gymGraphLabels,
            datasets: [{
                label: '',
                data: gymGraphData,
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    '#4e8c95',
                    '#cc8683',
                    '#6c953d',
                    '#3d647a',
                    '#1e74ae',
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    '#4e8c95',
                    '#cc8683',
                    '#6c953d',
                    '#3d647a',
                    '#1e74ae',
                ],
                borderWidth: 1
            }]
        };

        const gymGraphConfig = {
            type: 'bar',
            data: gymData,
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            // forces step size to be 50 units
                            stepSize: 10
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            boxWidth: 0
                        }
                    }
                },
            },
        };

        var gymGraph = new Chart(
            document.getElementById('buyer-graph'),
            gymGraphConfig
        );
        // USER GRAPH : ENS
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
