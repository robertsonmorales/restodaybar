@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="mx-4">
    <div class="card-group">
        <div class="card mb-sm-3 mr-sm-3 card-order-1">
            <div class="card-body flex-sm-column-reverse flex-lg-row">
                <div class="card-content">
                    <span class="text-muted font-size-sm">Your Earnings</span>
                    <div class="card-title d-flex align-items-center mb-auto">
                        <h3 class="mr-2">$15,000</h3>
                        <span class="text-success">
                            <i data-feather="trending-up"></i>
                        </span>
                    </div>
                </div>

                <x-atoms.circle-icon 
                    value="dollar-sign" 
                    type="card-icon bg-info text-white mb-sm-2 mb-md-0" />
            </div>
        </div>

        <div class="card mb-sm-3 mr-lg-3 card-order-2">
            <div class="card-body flex-sm-column-reverse flex-lg-row">
                <div class="card-content">
                    <span class="text-muted font-size-sm">Your Expenditures</span>
                    <div class="card-title d-flex align-items-center mb-auto">
                        <h3 class="mr-2">$10,123</h3>
                        <span class="text-success">
                            <i data-feather="trending-up"></i>
                        </span>
                    </div>
                </div>

                <x-atoms.circle-icon 
                    value="database" 
                    type="card-icon bg-danger text-white mb-sm-2 mb-md-0" />
            </div>
        </div>

        <div class="w-100 d-none d-sm-block d-lg-none"></div>

        <div class="card mb-sm-3 mr-sm-3 card-order-3">
            <div class="card-body flex-sm-column-reverse flex-lg-row">
                <div class="card-content align-items-sm-center align-items-lg-start w-100 mb-auto">
                    <span class="text-muted font-size-sm">Annual Budget Overview</span>
                    <h3 class="card-title">$45K</h3>
                    <div class="progress w-75">
                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                    </div>
                </div>

                <x-atoms.circle-icon 
                    value="calendar" 
                    type="card-icon bg-warning text-white mb-sm-2 mb-md-0" />
            </div>
        </div>

        <div class="card mb-sm-3 card-order-4">
            <div class="card-body flex-sm-column-reverse flex-lg-row">
                <div class="card-content">
                    <span class="text-muted font-size-sm">Verified Users</span>
                    <div class="card-title d-flex align-items-center mb-auto">
                        <h3 class="mr-2">15,123</h3>
                        <span class="text-success">
                            <i data-feather="trending-up"></i>
                        </span>
                    </div>
                </div>

                <x-atoms.circle-icon 
                    value="users" 
                    type="card-icon bg-primary text-white mb-sm-2 mb-md-0" />
            </div>
        </div>
    </div>    

    <!-- charts -->
    <div class="card-group">
        <div class="card mr-md-3 card-order-5">
            <div class="card-body">
                <div class="card-content w-100">
                    <div id="revenue-chart" class="revenue-chart" style="width: 100%; height: 100%;"></div>
                </div>                    
            </div> 
        </div>

        <div class="card card-order-6">
            <div class="card-body">
                <div class="card-content w-100">
                    <div id="expenditures-chart" class="expenditures-chart" style="width: 100%; height: 100%;"></div>
                </div>
            </div> 
        </div>
    </div>
    <!-- ends here -->
</div>
@endsection

@section('vendors-script')
<script src="{{ asset('vendors/apexcharts/apexcharts.js') }}"></script>
<script src="{{ asset('vendors/axios/axios.min.js') }}"></script>
<script src="{{ asset('vendors/jquery/jquery-3.4.1.min.js') }}"></script>
@endsection

@section('scripts')
<script src="{{ asset('js/charts/revenue.js') }}"></script>
<script src="{{ asset('js/charts/expenditures.js') }}"></script>
@endsection