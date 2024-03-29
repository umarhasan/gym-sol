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
                <div class="text-center">
                  <img src="{{ asset('uploads/member/profile/' . $user->profile) }}" alt="" class="rounded-circle" style="width: 200px; height: 200px;">
                </div>
              </div>
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
                            <strong>Phone:</strong>
                            <input class="form-control" type="text" name="phone" placeholder="phone" value="{{ $user->phone }}"> <!-- Confirm password field -->
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <strong>Fees:</strong>
                            <input class="form-control" type="text" name="fees" placeholder="fees" value="{{ isset($user->Fees) ? $user->Fees->amount : '' }}"> <!-- Confirm password field -->
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <strong>Expiry Date:</strong>
                            <input class="form-control" type="date" name="expiry" placeholder="MM/DD/YYYY" value="{{ isset($user->Fees) ? $user->Fees->expiry : '' }}">
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

<script>
  // Function to format the date as mm/dd/yyyy
  function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [month, day, year].join('/');
  }

  // Set the initial value of the input field to mm/dd/yyyy format
  var expiryInput = document.getElementById('expiry');
  expiryInput.value = formatDate(expiryInput.value);
</script>
@endsection
