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
                    <table id="order-listing" class="table dataTable no-footer" role="grid" aria-describedby="order-listing_info">
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
                          <td><img class="rounded-circle" width="35" src="{{$data->image}}" alt="" /></td>
                          <td>
                              <a href="{{route('member.profile',['id' => $data->id])}}" class="btn btn-xs btn-link" target="_blank">  {{$data->name}}  </a>
                          </td>
                          <td>
                              <span class="fs-12">{{$data->phone}}</span>
                          </td>
                          <td>
                              <span class="badge light badge-danger">
                                  <i class="fa fa-circle text-danger mr-1"></i>
                                Expired
                              </span>                        
                          </td>
                          <td>
                              <a href="https://wa.me/{{$data->phone}}?text=Your subscription is expired. Please renew to continue enjoying our services." type="button" class="btn btn-success btn-xs waves-effect btn-label waves-light" style="font-size: 12px; marginn-top: 1.5px;"><i class="fa-brands fa-whatsapp label-icon"></i> Notifiy</a>
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