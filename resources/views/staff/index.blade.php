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
                <h1>Staff Management</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Staff Management</li>
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
                    <h3 class="card-title">Staff List</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="pull-right">
                      @can('staff-create')
                        <a class="btn btn-primary" style="margin-bottom:5px" href="{{ route('staff.create') }}"> + Add Staff</a>
                      @endcan
                    </div>
                    <table id="order-listing" class="table dataTable no-footer" role="grid" aria-describedby="order-listing_info">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Fees</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($data)
                        @php
                        $id =1;
                        @endphp
                          @foreach($data as $key => $user)
                          <tr>
                            <td>{{$id++}}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->fees }}</td>
                            <td>
                              <div class="btn-group">
                                @can('user-edit')
                                  <a class="btn btn-primary btn-a" href="{{ route('staff.edit',$user->id) }}">Edit</a> &nbsp;   
                                @endcan
                                @can('user-permission')
                                  <a class="btn btn-primary btn-a" href="{{ route('users.permission',$user->id) }}"> Permission</a>    
                                @endcan
                                @can('user-delete')
                                <form method="post" action="{{route('staff.destroy',$user->id)}}">
                                  @csrf
                                  @method('delete')
                                  <button type="submit" onclick="return confirm('Are You Sure Want To Delete This.??')" type="button" class="btn btn-danger btn-b"><i class="fa fa-trash"></i></button>
                                </form>
                                @endcan
                              </div>
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