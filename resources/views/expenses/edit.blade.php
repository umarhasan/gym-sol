@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Update Member</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Update Member</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>
        <section class="content">
          <div class="container-fluid">
            @if (count($errors) > 0)
              <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  <form method="POST" action="{{ route('expenses.update', $expense->id) }}">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" value="{{ $expense->amount }}" required>
                      </div>
                      <div class="form-group">
                        <label for="expense_by">Expense By</label>
                        <input type="text" class="form-control" id="expense_by" name="expense_by" value="{{ $expense->expense_by }}" required>
                      </div>
                      <div class="form-group">
                        <label for="expense_by">Paid to</label>
                        <input type="text" class="form-control" id="paid_to" name="paid_to" value="{{ $expense->paid_to }}" required>
                      </div>
                      <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" va;ie="{{ $expense->date }}">
                          </div>
                      <div class="form-group">
                        <label for="details">Details</label>
                        <textarea class="form-control" id="details" name="details" rows="3" required>{{ $expense->details }}</textarea>
                      </div>
                      <!-- Add more fields as necessary -->

                      <button type="submit" class="btn btn-primary">Update</button>
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
