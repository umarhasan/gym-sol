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
                    <form method="post" class="" action="{{ route('member.update', $user->id) }}"> <!-- Change the route to update -->
                      @csrf
                      @method('PUT') <!-- Use PUT method for updating -->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <strong>Name:</strong>
                            <input class="form-control" name="name" value="{{ $user->name }}" required> <!-- Populate existing name -->
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <strong>Email:</strong>
                            <input class="form-control" type="email" name="email" value="{{ $user->email }}" required> <!-- Populate existing email -->
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <strong>Password:</strong>
                            <input class="form-control" type="password" name="password" placeholder="Enter new password"> <!-- Password field -->
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <strong>Confirm Password:</strong>
                            <input class="form-control" type="password" name="confirm_password" placeholder="Confirm new password"> <!-- Confirm password field -->
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <strong>Role:</strong>
                            <select name="role" class="form-control" required> <!-- Role field -->
                              @foreach($roles as $role)
                              <option value="{{ $role->name }}" @if($userRole == $role->name) selected @endif>{{ $role->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <strong>Department:</strong>
                            <select name="department" class="form-control" required> <!-- Department field -->
                              @foreach($departments as $department)
                              <option value="{{ $department->id }}" @if($user->department_id == $department->id) selected @endif>{{ $department->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                          <button type="submit" class="btn btn-primary">Update</button> <!-- Change button text to Update -->
                        </div>
                      </div>
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
