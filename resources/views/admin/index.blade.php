@extends('master')
@section('title', 'Dashboard | ' . env('APP_NAME'))

@section('styles')
    <style>
        .green-icon {
            color: #2add30;
        }

        .blue-icon {
            color: blue;
        }

        .light-blue-icon {
            color: #36b9cc;
        }

        .orange-icon {
            color: #f6c23e;
        }

        .brown-icon {
            color: #693e3e;
        }

        .border-left-custom {
            border-left: 4px solid #693e3e;
            /* Brown color */
        }

        .red-icon {
            color: red;
        }

        .border-left-custom {
            border-left: 4px solid red;
            /* Brown color */
        }
    </style>
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">الرئيسية</h1>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Content Row -->
        <div class="row">
            <!-- عدد العملاء الفعالين -->
            <div class="col-xl-2 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    عملاء فعالين</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $active_users }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x green-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- جميع العملاء -->
            <div class="col-xl-2 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    جميع العملاء</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $clients }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x blue-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- جميع المستخدمين -->
            <div class="col-xl-2 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">جميع المستخدمين
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $allusers }}</div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list  light-blue-icon" style="font-size: 25px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- جميع الأقسام -->
            <div class="col-xl-2 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    جميع الاقسام</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $catrgories }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-folder fa-2x orange-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- جميع الكتب -->
            <div class="col-xl-2 col-md-6 mb-4">
                <div class="card border-left-custom shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold brown-icon text-uppercase mb-1">
                                    جميع الكتب</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $books }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x brown-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--  عدد المستخدمين المشتركين في الباقات  -->
            <div class="col-xl-2 col-md-6 mb-4">
                <div class="card border-left-custom shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold red-icon text-uppercase mb-1">
                                    مستخدمين مشتركين</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $subscripe_clients }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-plus fa-2x red-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <div class="row">

        {{-- <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink" style="">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="myAreaChart" style="display: block; height: 320px; width: 782px;"
                            class="chartjs-render-monitor" width="977" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class="">
                                    <canvas id="myPieChart" style="display: block; height: 245px; width: 358px;"
                                        class="chartjs-render-monitor" width="447" height="306"></canvas>
                                </div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="myPieChart" style="display: block; height: 245px; width: 358px;"
                            class="chartjs-render-monitor" width="447" height="306"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Direct
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Social
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Referral
                        </span>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
