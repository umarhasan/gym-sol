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
                <h1>Users Management</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Users Management</li>
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
                    <h3 class="card-title">Users List</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="pull-right">
                      @can('user-create')
                        <a class="btn btn-primary" style="margin-bottom:5px" href="{{ route('users.create') }}"> + Add User</a>
                      @endcan
                    </div>
                    <!-- <table id="example1" class="table table-bordered table-striped"> -->
                    <table id="order-listing" class="table dataTable no-footer" role="grid" aria-describedby="order-listing_info">
                      <thead>
                        <tr>
                         <th>Expense by</th>
                          <th>Paid To</th>
                          <th>Amount</th>
                          <th>Date</th>
                          <th>Invoice</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($expenses)
                       
                        @foreach($expenses as $data)
                            <tr>
                                <td>
                                    {{$data->expense_by}}
                                </td>
                                <td>
                                    {{$data->paid_to}}
                                </td>
                                <td>{{$data->amount}}</td>
                                <td>{{$data->date}}</td>
                                <td>
                                    <a href="{{route('expenses-invoice',['id' => $data->id])}}" class="btn btn-xs btn-link"> {{$data->invoice_url}} </a>
                                </td>
                            </tr>
                          @endforeach
                        @endif
                      </tbody>
                    </table>
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