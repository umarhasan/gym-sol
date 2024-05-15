@extends('layouts.app')
<style>
    .pagination,
    .jsgrid .jsgrid-pager {
        display: flex;
        padding-left: 350px;
        margin-top: -25px;
        list-style: none;
        border-radius: 0.25rem;
    }
    .light.badge-warning {
    background-color: #fff5dd;
    color: #FFBC11;
}

.badge-warning {
    background-color: #FFBC11;
}
.badge {
    line-height: 1.5;
    border-radius: 1.25rem;
    font-size: 14px;
    font-weight: 600;
    padding: 4px 10px;
    border: 1px solid transparent;
}
</style>


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
                <h1>Expired Members</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Expired Members</li>
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
                    <h3 class="card-title">Expired Members</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example" class="table dataTable no-footer" role="grid" aria-describedby="order-listing_info">
                      <thead>
                        <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Status</th> 
                        <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($expiredMembers as $data)
                      <tr>
                          <td>
                              @if($data->image)
                                <img
                                        src="{{ asset('uploads/user/' . $data->image) }}" alt=""
                                        class="rounded-circle" style="width: 50px; height:50px;">
                                    
                                @else
                                <img
                                        src="{{ asset('admin/images/profile.jpg') }}"
                                        class="rounded-circle" style="width: 50px; height:50px;">
                                    
                                @endif
                              <a href="{{route('member.profile',['id' => $data->id])}}" class="btn btn-xs btn-link" target="_blank">  {{$data->name}}  </a>
                            </td>
                          
                          <td>
                              <span class="fs-12">{{$data->phone}}</span>
                          </td>
                          <td>
                            <span class="badge light badge-warning">
                                <i class="fa fa-circle text-warning mr-1" aria-hidden="true"></i>
                                 Expired
                            </span>                        
                        </td>
                          <td>
                              <a href="https://wa.me/{{$data->phone}}?text=Your subscription is expired. Please renew to continue enjoying our services." type="button" class="btn btn-success btn-xs waves-effect btn-label waves-light" style="font-size: 12px; marginn-top: 1.5px;"><i class="fa fa-bell"></i> Notifiy</a>
                          </td>
                      </tr>
                      @endforeach
 
                      </tbody>
                    </table>
                      {{ $expiredMembers->links('custom_pagiantion') }}
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