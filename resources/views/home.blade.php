@extends('layouts.master')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/morris/morris.css') }}" />

    <style type="text/css">

        .card-featured-syellow {
            border-color: #ffb100cf !important;
        }
        .summary-icon.bg-syellow {
            background-color: #ffb100cf;
        }
        .card-featured-sorg {
            border-color: #ff8159ad !important;
        }
        .summary-icon.bg-sorg {
            background-color: #ff8159ad;
        }
        .card-featured-sgreen {
            border-color: #5dca83 !important;
        }
        .summary-icon.bg-sgreen {
            background-color: #5dca83;
        }
        .card-featured-sgas {
            border-color: #607d8b !important;
        }
        .summary-icon.bg-sgas {
            background-color: #607d8b;
        }

        .widget-summary .summary-icon {
            line-height: 99px !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <h2>Dashboard</h2>
    <div class="right-wrapper text-right">
        <ol class="breadcrumbs">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
            <li><span>Dashboard</span></li>
        </ol>

        <a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>

    </div>
@endsection

@section('page-content')

    @if (auth()->user()->isAdmin())
        <div class="row">
            <div class="col-lg-12">
                <div class="row mb-3">
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-primary mb-3">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-primary">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Total Sales</h4>
                                            <div class="info">
                                                <strong class="amount">$ {{ $totalSales }}</strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a class="text-muted text-uppercase" href="{{route('invoice.index')}}">(All invoices)</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-secondary mb-3">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-secondary">
                                            <i class="fas fa-calendar-week"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">This Month sales</h4>
                                            <div class="info">
                                                <strong class="amount">$ {{ $thisMonthSales }}</strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a class="text-muted text-uppercase" href="#">---</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-sgas mb-3">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-sgas">
                                            <i class="fas  fa-life-ring"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Total Orders</h4>
                                            <div class="info">
                                                <strong class="amount">{{$totalOrders}}</strong>
                                                <span class="text-primary">({{$unpaidOrders}} unpaid)</span>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a class="text-muted text-uppercase" href="{{ route('order.main') }}">(All orders)</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-tertiary mb-3">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-tertiary">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">This Month Orders</h4>
                                            <div class="info">
                                                <strong class="amount">{{$thisMonthOrders}}</strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a class="text-muted text-uppercase" href="#">---</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-syellow mb-3">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-syellow">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Total Clients</h4>
                                            <div class="info">
                                                <strong class="amount">{{$totalClients}}</strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a class="text-muted text-uppercase" href="{{route('client.index')}}">(All clients)</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-sgreen mb-3">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-sgreen">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Team Members</h4>
                                            <div class="info">
                                                <strong class="amount">{{$totalTeam}}</strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a class="text-muted text-uppercase" href="{{ route('account.index') }}">(All clients)</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-sorg mb-3">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-sorg">
                                            <i class="fab fa-searchengin"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Total Services</h4>
                                            <div class="info">
                                                <strong class="amount">{{$totalServices}}</strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a class="text-muted text-uppercase" href="{{route('service.index')}}">(All services)</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-featured-left card-featured-quaternary mb-3">
                            <div class="card-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-quaternary">
                                            <i class="fas fa-running"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Running Order</h4>
                                            <div class="info">
                                                <strong class="amount">{{$totalRunningOrder}}</strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a class="text-muted text-uppercase" href="#">---</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mb-3">
                <section class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="chart-data-selector" id="salesSelectorWrapper">
                                    <h2>
                                        Sales:
                                        <strong>
                                            <select class="form-control" id="salesSelector">
                                                <option value="Porto Admin" selected>Porto Admin</option>
                                                <option value="Porto Drupal" >Porto Drupal</option>
                                                <option value="Porto Wordpress" >Porto Wordpress</option>
                                            </select>
                                        </strong>
                                    </h2>

                                    <div id="salesSelectorItems" class="chart-data-selector-items mt-3">
                                        <!-- Flot: Sales Porto Admin -->
                                        <div class="chart chart-sm" data-sales-rel="Porto Admin" id="flotDashSales1" class="chart-active" style="height: 203px;"></div>
                                        <script>

                                            var flotDashSales1Data = [{
                                                data: [
                                                    ["Jan", 140],
                                                    ["Feb", 240],
                                                    ["Mar", 190],
                                                    ["Apr", 140],
                                                    ["May", 180],
                                                    ["Jun", 320],
                                                    ["Jul", 270],
                                                    ["Aug", 180]
                                                ],
                                                color: "#0088cc"
                                            }];

                                            // See: js/examples/examples.dashboard.js for more settings.

                                        </script>

                                        <!-- Flot: Sales Porto Drupal -->
                                        <div class="chart chart-sm" data-sales-rel="Porto Drupal" id="flotDashSales2" class="chart-hidden"></div>
                                        <script>

                                            var flotDashSales2Data = [{
                                                data: [
                                                    ["Jan", 240],
                                                    ["Feb", 240],
                                                    ["Mar", 290],
                                                    ["Apr", 540],
                                                    ["May", 480],
                                                    ["Jun", 220],
                                                    ["Jul", 170],
                                                    ["Aug", 190]
                                                ],
                                                color: "#2baab1"
                                            }];

                                            // See: js/examples/examples.dashboard.js for more settings.

                                        </script>

                                        <!-- Flot: Sales Porto Wordpress -->
                                        <div class="chart chart-sm" data-sales-rel="Porto Wordpress" id="flotDashSales3" class="chart-hidden"></div>
                                        <script>

                                            var flotDashSales3Data = [{
                                                data: [
                                                    ["Jan", 840],
                                                    ["Feb", 740],
                                                    ["Mar", 690],
                                                    ["Apr", 940],
                                                    ["May", 1180],
                                                    ["Jun", 820],
                                                    ["Jul", 570],
                                                    ["Aug", 780]
                                                ],
                                                color: "#734ba9"
                                            }];

                                            // See: js/examples/examples.dashboard.js for more settings.

                                        </script>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-4 text-center">
                                <h2 class="card-title mt-3">Sales Goal</h2>
                                <div class="liquid-meter-wrapper liquid-meter-sm mt-3">
                                    <div class="liquid-meter">
                                        <meter min="0" max="100" value="35" id="meterSales"></meter>
                                    </div>
                                    <div class="liquid-meter-selector mt-4 pt-1" id="meterSalesSel">
                                        <a href="#" data-val="35" class="active">Monthly Goal</a>
                                        <a href="#" data-val="28">Annual Goal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    @else
        <h2 class="text-center text-dark">Welcome, {{ Auth()->user()->name }}!!!</h2>
    @endif

@endsection


@section('page-script')
    <script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-appear/jquery-appear.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js') }}"></script>
    <script src="{{ asset('assets/vendor/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/vendor/flot.tooltip/flot.tooltip.js') }}"></script>
    <script src="{{ asset('assets/vendor/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/vendor/flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('assets/vendor/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-sparkline/jquery-sparkline.js') }}"></script>
    <script src="{{ asset('assets/vendor/raphael/raphael.js') }}"></script>
    <script src="{{ asset('assets/vendor/morris/morris.js') }}"></script>
    <script src="{{ asset('assets/vendor/gauge/gauge.js') }}"></script>
    <script src="{{ asset('assets/vendor/snap.svg/snap.svg.js') }}"></script>
    <script src="{{ asset('assets/vendor/liquid-meter/liquid.meter.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/jquery.vmap.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/data/jquery.vmap.sampledata.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js') }}"></script>
@endsection
