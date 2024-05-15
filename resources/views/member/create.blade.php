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
                                    <h1>Member Form</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active">Create New Member</li>
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
                                            <form method="post" class="" action="{{ route('member.store') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <strong>Name:</strong>
                                                            <input class="form-control" name="name" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <strong>Phone:</strong>
                                                            <input class="form-control" type="text" name="phone"
                                                                id="phone" placeholder="923172112995" required>
                                                            <span id="phone-error" style="color: red;"></span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <strong>Gender:</strong><br>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="gender" value="male"
                                                                    required> Male
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="gender" value="female"> Female
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <strong>Expiry Date:</strong>
                                                            <input class="form-control" type="date" name="expiry" value=""
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <strong>Fees:</strong>
                                                            <input class="form-control" type="number" name="fees"
                                                                required>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <strong>Profile Image:</strong>
                                                            <input type="file" name="profile" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
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
            // Function to validate phone number format
            function validatePhone() {
                var phoneInput = document.getElementById('phone').value;
                var phoneRegex = /^[0-9]{12}$/; // Change this regex according to your desired phone number format

                if (!phoneRegex.test(phoneInput)) {
                    document.getElementById('phone-error').innerText =
                        'Please enter a valid 12-digit phone number'; // Display error message
                    document.getElementById('phone').setCustomValidity('Invalid phone number'); // Set custom validation message
                } else {
                    document.getElementById('phone-error').innerText = ''; // Clear error message
                    document.getElementById('phone').setCustomValidity(''); // Clear custom validation message
                }
            }

            // Add event listener to the phone input field to trigger validation on input change
            document.getElementById('phone').addEventListener('input', validatePhone);
        </script>
    @endsection
