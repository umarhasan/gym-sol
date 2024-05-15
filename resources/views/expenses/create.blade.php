@extends('layouts.app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h1>Create Expense</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active">Create Expense</li>
                                    </ol>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('expenses.store') }}">
                                                @csrf

                                                <div class="form-row">
                                                    <!-- Date Field -->
                                                    <div class="form-group col-md-6">
                                                        <h5>Date: {{ \Carbon\Carbon::now()->toDateString() }}</h5>
                                                        <input type="hidden" name="current_date" class="form-control" id="current_date"
                                                            name="current_date" disabled>
                                                    </div>
                                                    <!-- Current User Field -->
                                                    <div class="form-group col-md-6">
                                                        <h5>Name: {{ auth()->user()->name }}</h5>
                                                        <input type="hidden" class="form-control" id="amount"
                                                            name="user_name" value="{{ auth()->user()->name }}" disabled>
                                                    
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="amount">Amount</label>
                                                        <input type="number" class="form-control" id="amount"
                                                            name="amount" placeholder="Enter amount" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="expense_by">Expense By</label>
                                                        <input type="text" class="form-control" id="expense_by"
                                                            name="expense_by" placeholder="Enter name" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="details">Details</label>
                                                    <textarea class="form-control" id="details" name="details" placeholder="Enter details" rows="3" required></textarea>
                                                </div>
                                                <div class="form-row">
                                                     <div class="form-group col-md-6">
                                                        <label for="date">Date</label>
                                                        <input type="date" class="form-control" id="date" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="paid_to">Paid To</label>
                                                        <input type="text" class="form-control" id="paid_to"
                                                            name="paid_to" placeholder="Enter recipient" required>
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
                <script>
            // Get the current date
            var currentDate = new Date();

            // Format the date to YYYY-MM-DD which is the required format for <input type="date">
            var formattedDate = currentDate.toISOString().split('T')[0];

            // Set the formatted date as the value of the input field
            document.getElementById("current_date").value = formattedDate;
        </script>
    @endsection
