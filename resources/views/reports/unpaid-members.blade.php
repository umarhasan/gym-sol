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
                  <li class="breadcrumb-item active">Unpaid Member</li>
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
                    <h3 class="card-title">Unpaid Member</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="pull-right">
                      
                    </div>
                    <!-- <table id="example1" class="table table-bordered table-striped"> -->
                    <table id="order-listing" class="table dataTable no-footer" role="grid" aria-describedby="order-listing_info">
                      <thead>
                        <tr>
                        <th></th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($unPaidMembers as $data)
                        <tr>
                            <td><img class="rounded-circle" width="35" src="{{$data->image}}" alt="" /></td>
                            <td>
                                <a href="{{route('member.profile',['id' => $data->userId])}}" class="btn btn-xs btn-link" target="_blank"> {{$data->name}} </a>
                            </td>
                            <td>
                                <span class="fs-12">{{$data->phone}}</span>
                            </td>
                            <td>
                                <span class="badge light badge-warning">
                                    <i class="fa fa-circle text-warning mr-1"></i>
                                    Unpaid
                                </span>
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
        </section>
    </div>
  </div>
</div>
@endsection