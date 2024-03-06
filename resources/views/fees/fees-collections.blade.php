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
                <h1>Fees Collections</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Fees Collections</li>
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
                    <h3 class="card-title">Fees Collections</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    
                    <!-- <table id="example1" class="table table-bordered table-striped"> -->
                    <table id="order-listing" class="table dataTable no-footer" role="grid" aria-describedby="order-listing_info">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Amount</th>
                          <th>Expiry</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($collections)
                          @php
                            $i =1;
                          @endphp
                          @foreach ($collections as $index => $data)
                          @php $i++; @endphp
                                <tr>
                                  <td>
                                    <span class="fs-14"> {{ $i }} </span>
                                    </td>
                                    <td>
                                        <span class="fs-14"> {{$data->name}} </span>
                                    </td>
                                    <td>
                                        <span class="fs-14"> {{$data->phone}} </span>
                                    </td>
                                    <td>
                                        <span class="fs-14"> {{$data->amount}} </span>
                                    </td>
                                    <td>
                                        <span class="fs-14"> {{\Carbon\Carbon::parse($data->latest_expiry)->format('Y F d')}} </span>
                                    </td>
                                     <td>
                                        @php 
                                          $expired = Carbon\Carbon::now()->gte(Carbon\Carbon::parse($data->latest_expiry));
                                        @endphp
                                        @if ($expired)
                                            <span style="width: 100%" class="badge light badge-danger">
                                                <i class="fa-duotone fa-clock mr-1 text-danger"></i>  Subscription has expired.
                                            </span>
                                        @else
                                        @if(Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($data->latest_expiry))<=8)
                                            <span style="width: 100%" class="badge light badge-warning">
                                                <i class="fa-duotone fa-clock mr-1 text-warning"></i>  Subscription will expire in {{  Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($data->latest_expiry)) }} days
                                            </span>
                                        @elseif(Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($data->latest_expiry))>8)
                                          <span style="width: 100%" class="badge light badge-primary">
                                             <i class="fa-duotone fa-clock mr-1 text-primary"></i> &nbsp; 
                                             Subscription will expire in {{  Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($data->latest_expiry)) }} days.
                                          </span>
                                        @endif
                                       @endif 
                                     </td>
                                    <td>
                                          <a class="btn btn-warning btn-a" href="{{ route('fees.create',$data->id) }}"><i class="fa fa-file-invoice-dollar"></i> Recived payment</a>   
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