@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="mx-4">
    <div class="card-group">
        <div class="card mb-sm-3 mr-sm-3 card-order-1">
            <div class="card-body flex-sm-column-reverse flex-lg-row">
                <div class="card-content">
                    <span class="text-primary font-weight-normal font-size-sm mb-1">Monthly Earnings</span>
                    <div class="card-title h3 font-weight-600 d-flex align-items-center">
                        <span class="mr-2">$15,000</span>
                        <span class="text-success">
                            <i data-feather="trending-up"></i>
                        </span>
                    </div>
                </div>
                <span class="card-icon bg-primary text-white shadow mb-sm-2">
                    <i data-feather="dollar-sign"></i>
                </span>
            </div>
        </div>

        <div class="card mb-sm-3 mr-lg-3 card-order-2">
            <div class="card-body flex-sm-column-reverse flex-lg-row">
                <div class="card-content">
                    <span class="text-info font-weight-normal font-size-sm mb-1">Monthly Revenue</span>
                    <div class="card-title h3 font-weight-600 d-flex align-items-center">
                        <span class="mr-2">$15,123</span>
                        <span class="text-success">
                            <i data-feather="trending-up"></i>
                        </span>
                    </div>
                </div>
                <span class="card-icon bg-info text-white shadow mb-sm-2">
                    <i data-feather="database"></i>
                </span>
            </div>
        </div>

        <div class="w-100 d-none d-sm-block d-lg-none"></div>

        <div class="card mb-sm-3 mr-sm-3 card-order-3">
            <div class="card-body flex-sm-column-reverse flex-lg-row">
                <div class="card-content align-items-sm-center align-items-lg-start w-100">
                    <span class="text-secondary font-weight-normal font-size-sm mb-1">Annual Budget Overview</span>
                    <span class="card-title h3 font-weight-600">$45K</span>
                    <div class="progress w-75">
                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                    </div>
                </div>
                <span class="card-icon bg-secondary text-white shadow mb-sm-2">
                    <i data-feather="calendar"></i>
                </span>
            </div>
        </div>

        <div class="card mb-sm-3 card-order-4">
            <div class="card-body flex-sm-column-reverse flex-lg-row">
                <div class="card-content">
                    <span class="text-success font-weight-normal font-size-sm mb-1">Verified Users</span>
                    <div class="card-title h3 font-weight-600 d-flex align-items-center">
                        <span class="mr-2">15,123</span>
                        <span class="text-success">
                            <i data-feather="trending-up"></i>
                        </span>
                    </div>
                </div>
                <span class="card-icon bg-success text-white shadow mb-sm-2">
                    <i data-feather="users"></i>
                </span>
            </div>
        </div>
    </div>    

    <!-- charts -->
    <div class="card-group mb-4">
        <div class="card mr-md-3 card-order-5">
            <div class="card-body">
                <div class="card-content w-100">
                    <span class="text-primary font-weight-normal font-size-sm mb-1">Earnings Breakdown</span>
                    <div id="earnings-chart" class="earnings-chart" style="width: 100%; height: 100%;"></div>
                </div>                    
            </div> 
        </div>

        <div class="card card-order-6">
            <div class="card-body">
                <div class="card-content w-100">
                    <span class="text-primary font-weight-normal font-size-sm mb-1">Revenue Breakdown</span>
                    <div id="revenue-chart" class="revenue-chart" style="width: 100%; height: 100%;"></div>
                </div>                    
            </div> 
        </div>
    </div>
    <!-- ends here -->
</div>
@endsection

@section('vendors-script')
<script src="{{ asset('vendors/apexcharts/apexcharts.js') }}"></script>
@endsection

@section('scripts')
<script src="{{ asset('js/charts/earnings.js') }}"></script>
<script src="{{ asset('js/charts/revenue.js') }}"></script>
@endsection