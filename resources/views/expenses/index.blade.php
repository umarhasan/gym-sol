@extends('layouts.app')

@section('content')
      <style>
          .pagination,
          .jsgrid .jsgrid-pager {
              display: flex;
              padding-left: 350px;
              margin-top: -25px;
              list-style: none;
              border-radius: 0.25rem;
          }
      </style>
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>Expenses</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active">Expenses Management</li>
                                    </ol>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <a href="{{ route('expenses.create') }}" class="btn btn-primary">Add Expense</a>
                                    </div>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="today-tab" data-toggle="tab" href="#today"
                                                role="tab" aria-controls="today" aria-selected="true">Today</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="last_7_days-tab" data-toggle="tab" href="#last_7_days"
                                                role="tab" aria-controls="last_7_days" aria-selected="false">Last 7
                                                Days</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="months-tab" data-toggle="tab" href="#months"
                                                role="tab" aria-controls="months" aria-selected="false">Months</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="today" role="tabpanel"
                                            aria-labelledby="today-tab">
                                            <!-- Today's Expenses Content -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Today</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <table id="todayTable" class="table dataTable no-footer" role="grid"
                                                        aria-describedby="today">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Amount</th>
                                                                <th>Details</th>
                                                                <th>Date</th>
                                                                <th>Invoice URL</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($expensesToday as $expense)
                                                                <tr>
                                                                    <td>{{ $expense->id }}</td>
                                                                    <td>{{ $expense->amount }}</td>
                                                                    <td>{{ $expense->details }}</td>
                                                                    <td>{{ $expense->date }}</td>
                                                                    <td>{{ $expense->invoice_url }}</td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            @can('expenses-update')
                                                                            <a class="btn btn-primary btn-a"
                                                                                href="{{ route('expenses.create', $expense->id) }}"><i
                                                                                    class="fa fa-edit"></i></a>
                                                                            @endcan        
                                                                                    &nbsp;
                                                                            @can('expenses-delete')
                                                                            <form method="post"
                                                                                action="{{ route('expenses.destroy', $expense->id) }}">
                                                                                @csrf
                                                                                @method('delete')
                                                                                <button type="submit"
                                                                                    onclick="return confirm('Are You Sure Want To Delete This.??')"
                                                                                    type="button"
                                                                                    class="btn btn-danger btn-b"><i
                                                                                        class="fa fa-trash"></i></button>
                                                                            </form>
                                                                            @endcan
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="last_7_days" role="tabpanel"
                                            aria-labelledby="last_7_days-tab">
                                            <!-- Last 7 Days Expenses Content -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Last 7 Days</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <table id="last7days" class="table dataTable no-footer" role="grid"
                                                        aria-describedby="order-listing_info">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Amount</th>
                                                                <th>Details</th>
                                                                <th>Date</th>
                                                                <th>Invoice URL</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($expensesLast7Days as $expense)
                                                                <tr>
                                                                    <td>{{ $expense->id }}</td>
                                                                    <td>{{ $expense->amount }}</td>
                                                                    <td>{{ $expense->details }}</td>
                                                                    <td>{{ $expense->date }}</td>
                                                                    <td>{{ $expense->invoice_url }}</td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            @can('expenses-update')
                                                                            <a class="btn btn-primary btn-a"
                                                                                href="{{ route('expenses.create', $expense->id) }}"><i
                                                                                    class="fa fa-edit"></i></a>
                                                                            @endcan        
                                                                                    &nbsp;
                                                                            @can('expenses-delete')
                                                                            <form method="post"
                                                                                action="{{ route('expenses.destroy', $expense->id) }}">
                                                                                @csrf
                                                                                @method('delete')
                                                                                <button type="submit"
                                                                                    onclick="return confirm('Are You Sure Want To Delete This.??')"
                                                                                    type="button"
                                                                                    class="btn btn-danger btn-b"><i
                                                                                        class="fa fa-trash"></i></button>
                                                                            </form>
                                                                            @endcan
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="months" role="tabpanel"
                                            aria-labelledby="months-tab">
                                            <!-- Months Expenses Content -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Months</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <table id="monthTable" class="table dataTable no-footer"
                                                        role="grid" aria-describedby="months">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Amount</th>
                                                                <th>Details</th>
                                                                <th>Date</th>
                                                                <th>Invoice URL</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($expenses as $expense)
                                                                <tr>
                                                                    <td>{{ $expense->id }}</td>
                                                                    <td>{{ $expense->amount }}</td>
                                                                    <td>{{ $expense->details }}</td>
                                                                    <td>{{ $expense->date }}</td>
                                                                    <td>{{ $expense->invoice_url }}</td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            @can('expenses-update')
                                                                            <a class="btn btn-primary btn-a"
                                                                                href="{{ route('expenses.create', $expense->id) }}"><i
                                                                                    class="fa fa-edit"></i></a>
                                                                            @endcan        
                                                                                    &nbsp;
                                                                            @can('expenses-delete')
                                                                            <form method="post"
                                                                                action="{{ route('expenses.destroy', $expense->id) }}">
                                                                                @csrf
                                                                                @method('delete')
                                                                                <button type="submit"
                                                                                    onclick="return confirm('Are You Sure Want To Delete This.??')"
                                                                                    type="button"
                                                                                    class="btn btn-danger btn-b"><i
                                                                                        class="fa fa-trash"></i></button>
                                                                            </form>
                                                                            @endcan
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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
