@extends('layouts.app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    Dashboard
                </h3>
            </div>
            <div class="row grid-margin">
                <div class="col-12">
                    <div class="card card-statistics">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">

                                <div class="statistics-item">
                                    <a href="{{ route('users.index') }}" style="color: inherit; text-decoration: none;">
                                        <p>
                                            <i class="icon-sm fa fa-user mr-2"></i>
                                            Total Users
                                        </p>
                                        <h2>{{ $data['totalUsers'] }}</h2>
                                    </a>
                                </div>
                                
                                <div class="statistics-item">
                                    <a href="{{ route('users.index') }}" style="color: inherit; text-decoration: none;">
                                        <p>
                                            <i class="icon-sm fa fa-user mr-2"></i>
                                            Total Company
                                        </p>
                                        <h2>{{ $data['totalCompany'] }}</h2>
                                    </a>
                                </div>

                                <div class="statistics-item">
                                    <a href="{{ route('member.index') }}" style="color: inherit; text-decoration: none;">
                                        <p>
                                            <i class="icon-sm fa fa-user mr-2"></i>
                                            Total Members
                                        </p>
                                        <h2>{{ $data['totalMembers'] }}</h2>
                                    </a>
                                </div>
                                <div class="statistics-item">
                                    <a href="{{ route('staff.index') }}" style="color: inherit; text-decoration: none;">
                                        <p>
                                            <i class="icon-sm fa fa-user mr-2"></i>
                                            Total Staff
                                        </p>
                                        <h2>{{ $data['totalStaff'] }}</h2>
                                    </a>
                                </div>
                                <div class="statistics-item">
                                    <a href="fees-collections" style="color: inherit; text-decoration: none;">
                                        <p>
                                            <i class="icon-sm fas fa-check-circle mr-2"></i>
                                            Total Fees
                                        </p>
                                        <h2>{{ $data['totalFees'] }}</h2>
                                    </a>
                                </div>
                                <div class="statistics-item">
                                    <a href="{{ route('expenses.index') }}" style="color: inherit; text-decoration: none;">
                                        <p>
                                            <i class="icon-sm fas fa-chart-line mr-2"></i>
                                            Total Expenses
                                        </p>
                                        <h2>{{ $data['totalExpenses'] }}</h2>
                                    </a>
                                </div>
                                <div class="statistics-item">
                                    <p>
                                        <i class="icon-sm fas fa-circle-notch mr-2"></i>
                                        Profit & Loss
                                    </p>
                                    <h2>{{ $data['profitAndLoss'] }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <i class="fas fa-gift"></i>
                                Monthly Profit & Loss
                            </h4>
                            <canvas id="orders-chart" data-labels="{{ json_encode($chartData['labels']) }}"
                                data-values="{{ json_encode($chartData['values']) }}"></canvas>
                            <div id="orders-chart-legend" class="orders-chart-legend"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <i class="fas fa-chart-line"></i>
                                Total Fess
                            </h4>
                            <h2 class="mb-5">{{ $data['totalFees'] }} <span class="text-muted h4 font-weight-normal">Fees</span></h2>
                            <canvas id="sales-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
    @endsection
