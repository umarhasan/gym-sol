@extends('layouts.app')

<style>
    .form-control { 
        border-radius: 0px 10px 10px 0px !important;
        padding: 20px !important;
    }
    .input-group-text { 
        border-radius: 10px 0px 0px 0px !important;
    }

    .card { 
        border-radius: 1px !important;
    }
    .card {
    margin-bottom: 1.875rem;
    background-color: #fff;
    transition: all .5s ease-in-out;
    position: relative;
    border: 4px solid #5a4e4e0d;
    border-radius: 1.25rem;
    box-shadow: 0px 12px 23px 0px rgba(160, 44, 250, 0.04);
    height: calc(100% - 30px);
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
                <h1>Clubs Form</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Create New Clubs</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>
        <section class="card content">
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
              <form method="POST" action="{{ isset($club) ? route('club.settings.update', $club->id) : route('club.settings.createOrUpdate') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($club))
                    @method('PUT')
                @endif
                <div class="row">
                  <div class="col-md-9">
                    <div class="card-header">
                        <h4 class="text text-black-50">Gym Details</h4>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="input-group input-group-sm mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"> GYM Name </span>
                                </div>
                                <input type="text" name="gym_name" style="height: 55px !important" class="form-control form-control-sm {{ $errors->has('gym_name') ? 'is-invalid' : (strlen(isset($club) ? $club->gym_name : '')>0 ? 'is-valid' : null) }}" placeholder="GYM Name" wire:model="gym_name" value="{{ old('gym_name', isset($club) ? $club->gym_name : '') }}">
                                <br>
                                @error('gym_name')
                                <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                                @enderror
                            </div>
                            <div class="input-group input-group-sm mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"> GYM Title </span>
                                </div>
                                <input type="text" name="gym_title" style="height: 55px !important" class="form-control form-control-sm {{ $errors->has('gym_title') ? 'is-invalid' : (strlen(isset($club) ? $club->gym_title : '')>0 ? 'is-valid' : null) }}" placeholder="GYM Title" wire:model="gym_title" value="{{ old('gym_title', isset($club) ? $club->gym_title : '') }}">
                                @error('gym_title')
                                    <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group input-group-sm mb-3 col-md-6">
                            <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"> City </span>
                                </div>
                                <input type="text" name="city" style="height: 55px !important" class="form-control form-control-sm {{ $errors->has('city') ? 'is-invalid' : (strlen(isset($club) ? $club->city : '')>0 ? 'is-valid' : null) }}" placeholder="GYM Title" wire:model="city" value="{{ old('city', isset($club) ? $club->city : '') }}">
                                @error('City')
                                    <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                                @enderror
                            </div>
                            <div class="input-group input-group-sm mb-3 col-md-6">
                              <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white"> Notification Days </span>
                              </div>
                                <input type="number" name="notification_days" style="height: 55px !important" class="form-control form-control-sm {{ $errors->has('notification_days') }}" placeholder=" Notification Days" wire:model="notification_days" value="{{ old('notification_days', isset($club) ? $club->notification_days : '') }}">
                                @error('notification_days')
                                    <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                                <div class="input-group input-group-md mb-3 col-md-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white"> Location </span>
                                    </div>
                                    <textarea name="location" class="form-control form-control-sm {{ $errors->has('location') ? 'is-invalid' : (strlen(isset($club) ? $club->location : '')>0 ? 'is-valid' : null) }}" cols="30" rows="4" placeholder="Location" wire:model="location" value="{{ old('location', isset($club) ? $club->location : '') }}">{{ isset($club) ? $club->location : '' }}</textarea>
                                    @error('location')
                                    <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                                @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-group input-group-md mb-3 col-md-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white"> Address </span>
                                    </div>
                                    <textarea name="address" class="form-control form-control-sm {{ $errors->has('address') ? 'is-invalid' : (strlen(isset($club) ? $club->address : '')>0 ? 'is-valid' : null) }}" cols="30" rows="4" placeholder="Address" wire:model="location" value="{{ old('address', isset($club) ? $club->address : '') }}">{{ isset($club) ? $club->address : '' }}</textarea>
                                    <br>
                                    @error('address')
                                    <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                                    @enderror
                                </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <textarea name="about" class="form-control form-control-sm {{ $errors->has('about') ? 'is-invalid' : (strlen(isset($club) ? $club->about : '')>0 ? 'is-valid' : null) }}" cols="30" rows="6" placeholder="About the GYM (300+ words) " wire:model="about" value="{{ old('about', isset($club) ? $club->about : '') }}">{{ isset($club) ? $club->about : '' }}</textarea>
                                @error('about')
                                <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                                @enderror
                            </div>  
                        </div>
                    </div>
                    <!-- Start Stack hol  ders-->
                    <div class="row">
                        <div class="card col-md-12">
                            <div class="card-header">
                                <h4 class="text text-black-50">Stack Holder</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="input-group input-group-sm mb-3 col-md-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-primary text-white">Owner Name</span>
                                        </div>
                                        <input type="text" name="owner_name" class="form-control {{ $errors->has('club->owner_name') ? 'is-invalid' : (strlen(isset($club) ? $club->owner_name : '')>0 ? 'is-valid' : null) }}" placeholder="Owner Name" wire:model="owner_name" style="padding: 20px;" value="{{ old('owner_name', isset($club) ? $club->owner_name : '') }}" />
                                        <br>
                                        @error('owner_name')
                                        <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                                        @enderror
                                    </div>
                                    <div class="input-group input-group-sm mb-3 col-md-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-primary text-white">Owner Phone</span>
                                        </div>
                                        <input type="text" name="owner_phone" class="form-control form-control-sm {{ $errors->has('owner_phone') ? 'is-invalid' : (strlen(isset($club) ? $club->owner_phone : '')>0 ? 'is-valid' : null) }}" placeholder="Owner Name" wire:model="owner_phone" value="{{ old('owner_phone', isset($club) ? $club->owner_phone : '') }}">
                                        <br> 
                                        @error('owner_phone')
                                        <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-group input-group-sm mb-3 col-md-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-primary text-white">Manager Name</span>
                                        </div>
                                        <input type="text" name="manager_name" class="form-control form-control-sm {{ $errors->has('manager_name') ? 'is-invalid' : (strlen(isset($club) ? $club->manager_name : ' ')>0 ? 'is-valid' : null) }}" placeholder="Manager Name" wire:model="manager_name" value="{{ old('manager_name', isset($club) ? $club->manager_name : '') }}">
                                        <br>
                                        @error('manager_name')
                                            <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                                        @enderror
                                    </div>
                                    <div class="input-group input-group-sm mb-3 col-md-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-primary text-white">Manager Phone</span>
                                        </div>
                                        <input type="text" name="manager_phone" class="form-control form-control-sm {{ $errors->has('club->manager_phone') ? 'is-invalid' : (strlen(isset($club) ? $club->manager_phone : '')>0 ? 'is-valid' : null) }}" placeholder="Manger Phone" wire:model="manager_phone" value="{{ old('manager_phone', isset($club) ? $club->manager_phone : '') }}">
                                        <br>
                                        @error('manager_phone')
                                            <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Stack holders -->
                    <!-- Start Whatsapp -->
                    <div class="row">
                        <div class="card col-md-12">
                            <div class="card-header">
                                <h4 class="text text-black-50">Whatsapp Configuration</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="input-group input-group-sm mb-3 col-md-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-success text-white"><i class="fa-brands fa-whatsapp"></i> &nbsp; Active Whatsapp No</span>
                                        </div>
                                        <input type="text" name="active_whatsapp_no" class="form-control form-control-sm {{ $errors->has('active_whatsapp_no') ? 'is-invalid' : (strlen(isset($club) ? $club->active_whatsapp_no : '')>0 ? 'is-valid' : null) }}" placeholder="Active Whatsapp No" wire:model="active_whatsapp_no" value="{{ old('active_whatsapp_no', isset($club) ? $club->active_whatsapp_no : '') }}">
                                        <br>
                                        @error('active_whatsapp_no')
                                            <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="input-group input-group-sm mb-3 col-md-12">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text bg-primary text-white">Phone</span>
                                      </div>
                                      <input type="text" name="phone" minlength="12" class="form-control form-control-sm" placeholder="921234567890" value="{{ old('phone', isset($club) ? $club->phone : '') }}">
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Whatsapp -->
                  </div>
                  
                  <div class="card col-md-3">
                      <div class="card-header">
                          <h4 class="text text-capitalize text-black-50">
                              Logo
                          </h4>
                      </div>
                      <div class="card-body" style="margin:0px !important; padding:0px !important;">
                          <br>
                          <div class="form-group" style="display:flex; justify-content: center; align-items: center">
                           @if($club && $club->logo)
                                <img src="{{ asset('uploads/club-logo/' . $club->logo) }}" alt="logo" style="width:130px; height: 90px;" class="img img-fluid img-rounded img-circle">
                            @else
                                <img src="{{ asset('path_to_default_logo_if_not_found.jpg') }}" alt="Default Logo" style="width:130px; height: 90px;" class="img img-fluid img-rounded img-circle">
                            @endif 
                          </div>

                          <div class="input-group input-group-sm mb-3">
                              <div class="input-group-prepend">
                                      <span class="input-group-text bg-primary text-white"> Logo </span>
                              </div>
                              <input type="file" name="logo" class="form-control form-control-sm {{ $errors->has('logo') ? 'is-invalid' : (strlen(isset($club) ? $club->logo : '')>0 ? 'is-valid' : null) }}" placeholder="logo" wire:model="logo">
                              @error('logo')
                              <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                              @enderror
                          </div>
                      </div>

                      <div class="card-header">
                          <h4 class="text-black-50">
                              Favicon
                          </h4>
                      </div>
                      <div class="card-body" style="margin:0px !important; padding:0px !important;">
                          <br>
                          <div class="form-group" style="display:flex; justify-content: center; align-items: center">
                          @if($club && $club->logo)
                            <img src="{{ asset('uploads/club-favicon/' . $club->favicon) }}" alt="favicon" alt="logo" style="width:130px; height: 90px;" class="img img-fluid  img-rounded img-circle">    
                            @else
                                <img src="{{ asset('path_to_default_logo_if_not_found.jpg') }}" alt="Default Logo" style="width:130px; height: 90px;" class="img img-fluid img-rounded img-circle">
                            @endif 
                          </div>

                          <div class="input-group input-group-sm mb-3">
                              <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"> favicon </span>
                              </div>
                              <input type="file" name="favicon" class="form-control form-control-sm {{ $errors->has('favicon') ? 'is-invalid' : (strlen(isset($club) ? $club->favicon : '')>0 ? 'is-valid' : null) }}" placeholder="logo" wire:model="logo">
                              @error('logo')
                              <span class="text text-danger text-invalid text-bold"> {{$message}} </span>
                              @enderror
                          </div>


                      </div>
                  </div>

                </div>
                <div class="form-group">
                      <button type="submit" class="btn btn-primary">{{ isset($club) ? 'Update' : 'Create' }}</button>
                  </div>
              </form>
          </div>
        </section>
    </div>
  </div>
</div>
@endsection