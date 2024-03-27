@extends('layouts.app')
<style>
    /* Adjustments for form layout */
    .card-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .dropdown {
        margin-bottom: 5px;
        margin-right: 20px; /* Adjust as needed */
    }

    #dateRangeInputs {
        display: flex;
        align-items: flex-end;
    }

    #dateRangeInputs .form-group {
        margin-bottom: 0;
        margin-right: 10px; /* Adjust as needed */
    }

    #dateRangeInputs .btn-primary {
        margin-left: 10px; /* Push the button to the right */
    }

    /* Adjustments for label */
    label {
        margin-right: 10px; /* Adjust as needed */
    }

    /* Adjustments for dropdown button */
    .dropdown-toggle {
        white-space: nowrap; /* Prevent wrapping of text */
    }
   
</style>
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <!-- <h1>Members Expiring Soon</h1> -->
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Profit and Loss</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h1>Profit and Loss</h1>
                                <h6>Work Hard. Have Fun. Make History</h6>
                            </div>
                            <!-- Form for filtering -->
                            <form id="filterForm" action="{{ route('profit_loss') }}" method="GET">
                              <div class="card-body d-flex align-items-end justify-content-between">
                              <div class="dropdown mb-3 ml-auto" style="margin-bottom: 0rem !important;">
                                  <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" id="filterDropdown">
                                      @if($filterBy == 'weekly')
                                      Current Week
                                      @elseif($filterBy == 'monthly')
                                      Current Month
                                      @elseif($filterBy == 'yearly')
                                      Current Year
                                      @else
                                      Date Range
                                      @endif
                                  </button>
                                  <div class="dropdown-menu dropdown-menu-right">
                                      <a class="dropdown-item{{ $filterBy == 'weekly' ? ' active' : '' }}" data-value="weekly">Current Week</a>
                                      <a class="dropdown-item{{ $filterBy == 'monthly' ? ' active' : '' }}" data-value="monthly">Current Month</a>
                                      <a class="dropdown-item{{ $filterBy == 'yearly' ? ' active' : '' }}" data-value="yearly">Current Year</a>
                                      <a class="dropdown-item{{ $filterBy == 'custom' ? ' active' : '' }}" data-value="custom">Date Range</a>
                                  </div>
                              </div>
                                  <div id="dateRangeInputs" class="flex-grow-1" style="display: {{ $filterBy == 'custom' ? 'flex' : 'none' }};">
                                      <div class="form-group mb-0 mr-2">
                                          <label for="startDate">Start Date</label>
                                          <input type="date" class="form-control" id="startDate" name="startDate" value="{{ $startDate ?? '' }}">
                                      </div>
                                      <div class="form-group mb-0 mr-2">
                                          <label for="endDate">End Date</label>
                                          <input type="date" class="form-control" id="endDate" name="endDate" value="{{ $endDate ?? '' }}">
                                      </div>
                                      <button type="submit" class="btn btn-primary">Filter</button>
                                  </div>
                              </div>
                              <input type="hidden" id="filterBy" name="filterBy" value="{{ $filterBy }}">
                          </form>
                            <!-- End Form -->

                            <!-- Table for displaying profit and loss report -->
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Total Income</td>
                                            <td>${{ $totalIncome }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Expenses</td>
                                            <td>${{ $totalExpense }}</td>
                                        </tr>
                                        <tr>
                                            <td>Net Profit/Loss</td>
                                            <td>${{ $netProfitLoss }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.dropdown-item').click(function () {
            var value = $(this).data('value');
            $('#filterBy').val(value);
            $('#filterForm').submit(); // Submit the form
        });

        // Handle displaying date range inputs
        $('#filterDropdown').on('click', function () {
            var selectedValue = $('#filterBy').val();
            if (selectedValue === 'custom') {
                $('#dateRangeInputs').slideDown();
            } else {
                $('#dateRangeInputs').slideUp();
            }
        });

        // Automatically open date range inputs on "Date Range" option select
        $(document).on('click', '.dropdown-item[data-value="custom"]', function () {
            $('#dateRangeInputs').slideDown();
        });
    });
</script>
@endsection


