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
                          <div class="form-group col-md-6">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="expense_by">Expense By</label>
                            <input type="text" class="form-control" id="expense_by" name="expense_by" placeholder="Enter name" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="details">Details</label>
                          <textarea class="form-control" id="details" name="details" placeholder="Enter details" rows="3" required></textarea>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="paid_to">Paid To</label>
                            <input type="text" class="form-control" id="paid_to" name="paid_to" placeholder="Enter recipient" required>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="club_id">Club ID</label>
                            <input type="text" class="form-control" id="club_id" name="club_id" placeholder="Enter club ID">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="invoice_url">Invoice URL</label>
                            <input type="text" class="form-control" id="invoice_url" name="invoice_url" placeholder="Enter invoice URL">
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

@endsection
