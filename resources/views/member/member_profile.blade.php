@extends('layouts.app')
<style>
        

    .whatsapp-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    }

    .whatsapp-link {
        display: inline-block;
        margin-right: 10px;
    }
    .overlay-box:after {
    content: "";
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    position: absolute;
    opacity: 0.85;
    background: #0B2A97;
    z-index: -1;
}
        @media screen and (max-width: 767px) {
            #member-profile-page {
                margin-top: 5% !important;
            }

            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                text-align: left;
            }

            table.dataTable thead th .fs-16 {
                font-size: 14px !important;
            }
        }

        .dataTables_wrapper .dataTables_info {
            clear: both;
            float: left !important;
            padding-top: 0.755em;
            margin-left: 20px !important;
        }
    </style>
    @if($latestSubscription->latest_expiration!='')
        @if($timeLeft<=3)
            <style>
                .overlay-box:after {
                    background-color: #ff5e6d !important;
                }

                #member-info-card {
                    background-color: #ff5e6d !important;
                }

                #member-info-card h4 {
                    color: white !important;
                }
            </style>
        @elseif($timeLeft<=8)
            <style>
                .overlay-box:after {
                    background-color: #FFBC11 !important;
                }

                #member-info-card {
                    background-color: #FFBC11 !important;
                }

                #member-info-card h4 {
                    color: white !important;
                }
            </style>
        @elseif(Carbon\Carbon::parse($latestSubscription->latest_expiration)->gte(Carbon\Carbon::now()))
            <style>
                .overlay-box:after {
                    background-color: #0B2A97 !important;
                }

                #member-info-card {
                    background-color: #0B2A97 !important;
                }

                #member-info-card h4 {
                    color: white !important;
                }
            </style>
        @else
            <style>
                .overlay-box:after {
                    background-color: #F94687 !important;
                }

                #member-info-card {
                    background-color: #F94687 !important;
                }

                #member-info-card h4 {
                    color: white !important;
                }
            </style>
        @endif
    @else
        <style>
            .overlay-box:after {
                background-color: #F4F5F9 !important;
            }

            #member-info-card:after {
                background-color: #F4F5F9 !important;
                color: black !important;
            }

            .member-name-h3 {
                color: black !important;
            }
        </style>
    @endif

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="content-wrapper">
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Edit User</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Edit User</li>
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
                    <div class="row" id="member-profile-page">
                        <!-- Left Column - Member Details -->
                        <div class="col-xl-4 col-lg-4 col-sm-12 col-md-12">
                            <div class="card overflow-hidden" style="margin-bottom: 10px;">
                                <div class="text-center p-3 overlay-box" style="background-image: url({{ asset('assets/images/big/img1.jpg') }});background: #222b34;">
                                    <!-- Profile Photo (commented out) -->
                                    <!-- <div class="profile-photo">
                                        <img src="{{ $member->image != '' ? $member->image : ($member->gender == 'male' ? asset('assets/male-placeholder.jpg') : asset('assets/female-placeholder.jpg')) }}" width="100" class="img-fluid rounded-circle" alt="" />
                                    </div> -->
                                    <h3 class="mt-3 mb-1 text-white member-name-h3">{{ $member->name }}</h3>
                                    <p class="text-white mb-0 member-name-h3">{{ $member->email }}</p>
                                </div>
                                <ul class="list-group list-group-flush mb-0">
                                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0"> Phone </span> <strong class="text-muted">{{ $member->phone }} </strong></li>
                                    <li class="list-group-item d-flex justify-content-between" style="border-bottom: 0.2px solid rgba(0, 0, 0, 0.1);"><span class="mb-0">Fees</span> <strong class="text-muted"> {{ $member->fees }} </strong></li>
                                    <li class="list-group-item d-flex flex-column justify-content-between" style="border-bottom: 0.2px solid rgba(0, 0, 0, 0.1); width: 100%;">
                                            
                                            @if($latestSubscription->latest_expiration != '')
                                                    @if($expired)
                                                    <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-danger" data-toggle="tooltip" data-placement="top" title="Subscription has expired - {{ $timeLeft }} days">
                                                                <div style="display: flex; align-items: center;">
                                                                    <i class="fa fa-clock mr-1 text-white"></i>
                                                                    <span>&nbsp; Subscription has been expired {{ ($timeLeft ?? 0) > 0 ? "-" . ($timeLeft ?? 0) : ($timeLeft ?? 0) }} days left</span>
                                                                </div>
                                                            </span>
                                                        <br>
                                                    @else
                                                        @if($timeLeft <= 3)
                                                            <span class="badge light badge-danger" style="width: 100%;">
                                                                <i class="fa-duotone fa-timer mr-1"></i>
                                                               
                                                                Subscription has been  expired in {{ $timeLeft }} days ago
                                                            </span>
                                                            <br>
                                                        
                                                        @elseif($timeLeft <= 8)
                                                        <span class="badge light badge-warning" style="width: 100%;">
                                                            <i class="fa-duotone fa-timer mr-1"></i>
                                                            Subscription will expire in {{ $timeLeft }} days
                                                        </span>
                                                        <br>
                                                            
                                                        @elseif(Carbon\Carbon::parse($latestSubscription->latest_expiration)->gte(Carbon\Carbon::now()))
                                                            <span class="badge light badge-primary" style="width: 100%;">
                                                                <i class="fa-duotone fa-timer mr-1"></i>
                                                                Subscription will expire in {{ $timeLeft }} days
                                                            </span>
                                                        @else
                                                            <span class="badge light badge-danger" style="width: 100%;">
                                                                <i class="fa-duotone fa-timer mr-1"></i>
                                                                Subscription is expired
                                                            </span>
                                                            <br>
                                                            <a href="https://wa.me/{{ $member->phone }}?text=Your subscription is expired. Please renew to continue enjoying our services." type="button" class="btn btn-success btn-xs waves-effect btn-label waves-light" style="font-size: 12px; marginn-top: 1.5px;"><i class="fa fa-whatsapp label-icon"></i> Notify</a>
                                                        @endif
                                                    @endif    
                                             @else
                                                <span class="badge light badge-light" style="width: 100%;">
                                                    <i class="fa-duotone fa-timer mr-1"></i>
                                                    Not paid yet!
                                                </span>
                                            
                                            @endif
                                            
                                        
                                            
                                    </li>
                                </ul>
                                <div class="card-footer pt-0 pb-0 text-center" style="margin-bottom: 2%;">
                                    <div class="row">
                                        <div class="col-2 pt-3 pb-3">
                                            
                                        </div>
                                        <div class="col-8 pt-3 pb-3">
                                            
                                         @if($latestSubscription->latest_expiration != '')
                                                @if($expired)
                                                    <a href="https://api.whatsapp.com/send?phone={{ $member->phone }}&text=Subscription has been  expired in {{ ($timeLeft ?? 0) > 0 ? "-" . ($timeLeft ?? 0) : ($timeLeft ?? 0) }} days left" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp" width="40" height="40"></a>
                                                @else
                                                        @if($timeLeft <= 3)
                                                        <a href="https://api.whatsapp.com/send?phone={{ $member->phone }}&text=Subscription has been  expired in {{ $timeLeft }} days ago" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp" width="40" height="40"></a>
                                                            
                                                        @elseif ($timeLeft <= 8)
                                                            <a href="https://api.whatsapp.com/send?phone={{ $member->phone }}&text=Subscription has been  expired in {{ $timeLeft }} days ago" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp" width="40" height="40" ></a>
                                                           
                                                         @elseif(Carbon\Carbon::parse($latestSubscription->latest_expiration)->gte(Carbon\Carbon::now()))
                                                           <a href="https://api.whatsapp.com/send?phone={{ $member->phone }}&text=Subscription will expire in {{ $timeLeft }} days" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp" width="40" height="40"></a>
                                                         @else
                                                            <a href="https://api.whatsapp.com/send?phone={{ $member->phone }}&text=Subscription is expired" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp" width="40" height="40"></a>
                                                        @endif      
                                                @endif
                                        @else
                                         <a href="https://api.whatsapp.com/send?phone={{ $member->phone }}&text=Not paid Yet!" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
                                         
                                        @endif 
                                           
                                        </div>
                                        <div class="col-2 pt-3 pb-3">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right Column - Member Info and Actions -->
                        <div class="col-xl-8 col-lg-8 col-sm-12 col-md-8">
                            <div class="card overflow-hidden">
                                <div class="card-header" id="member-info-card">
                                    <div class="d-flex mr-3 align-items-center">
                                        <h4 class="fs-20 mb-0">Member Info</h4>
                                    </div>
                                </div>
                                <div class="card-body p-0 mt-2 px-2">
                                    <div class="row">
                                        <div class="col-md-12 mb-3" style="display: flex; justify-content: center; align-items: center; padding:0px; margin:0px; margin-top: -2%">
                                            <div class="text-center overlay-box bg-light" style="width:100%; padding:0px; margin:0px; background-image: url({{ asset('assets/images/big/img1.jpg') }});">
                                                <!-- Profile Photo (commented out) -->
                                                <!-- <div class="profile-photo">
                                                    <img src="{{ $member->image!='' ? $member->image : ($member->gender=='male' ? asset('assets/male-placeholder.jpg') : asset('assets/female-placeholder.jpg')) }}" width="100" class="img-fluid rounded-circle" alt="" />
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>

                                    {{-- START VIEWING MODE OF MEMBER --}}
                                    <div class="table-responsive">
                                        <table class="table table-responsive-md">
                                            <thead>
                                                <tr>
                                                    <th class="width80">#</th>
                                                    <th class="width340">NAME</th>
                                                    <th>PHONE</th>
                                                    <th>DOB</th>
                                                    <th>GENDER</th>
                                                    <th>FEES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="width240">{{ $member->name }}</td>
                                                    <td>{{ $member->phone }}</td>
                                                    <td>{{ $member->dob }}</td>
                                                    <td>{{ $member->gender }}</td>
                                                    <td>{{ $member->fees }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                  
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <!-- Subscription -->
                    <div class="row" wire:ignore>
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12">
                            <div class="card overflow-hidden">
                                <div class="card-header bg-white">
                                    <div class="d-flex mr-3 align-items-center">
                                        <span class="p-sm-3 p-2 mr-sm-3 mr-2 rounded-circle">
                                            <i class="fa fa-light fa-money-bill-wave fs-22" style="clolor: #222b34;"></i>
                                        </span>
                                        <h4 class="fs-20 text-black mb-0">Subscriptions History</h4>
                                    </div>
                                </div>
                                <div class="card-body p-0 mt-2 px-2">
                                    <div class="table-responsive">
                                        <table id="order-listing1" class="table dataTable no-footer subscription-dt" role="grid" aria-describedby="order-listing_info">
                                            <thead>
                                                <tr>
                                                    <th><span class="font-w600 text-black fs-16">Paid On</span></th>
                                                    <th><span class="font-w600 text-black fs-16">Expire Date</span></th>
                                                    <th><span class="font-w600 text-black fs-16">Amount</span></th>
                                                    <th><span class="font-w600 text-black fs-16">Action</span></th>
                                                </tr>
                                            </thead>
                                            <tbody id="subscription-table-body">
                                                @foreach ($subscriptions as $index => $data)
                                            <tr>
                                                <td>
                                                    <span class="fs-14">{{ Carbon\Carbon::parse($data->date)->format('F d, Y') }}</span>
                                                </td>
                                                <td>
                                                    <span class="fs-14">{{ Carbon\Carbon::parse($data->expiry)->format('F d, Y') }}</span>
                                                </td>
                                                <td>
                                                    <span class="fs-14">{{ $data->amount }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <button type="button" class="btn btn-primary shadow btn-xs sharp mr-1" data-toggle="modal" data-target="#exampleModal{{ $data->id }}" data-whatever="@mdo"><i class="fa fa-edit"></i></button>
                                                       <form method="post" action="{{ route('subscriptions.delete', $data->id) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger shadow btn-xs sharp"  onclick="confirm('Are you sure you want to delete the record')" style="margin: 0px 0px -12px 0px;"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                       
                                                    </div>
                                                </td>
                                            </tr>
                                                    <!-- Edit Modal -->
                                              <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Subscriptions Update</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                         <form action="{{ route('subscriptions.update', $data->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label for="start_date">Start Date:</label>
                                                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ Carbon\Carbon::parse($data->date)->format('Y-m-d') }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="expiry_date">Expiry Date:</label>
                                                                        <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ Carbon\Carbon::parse($data->expiry)->format('Y-m-d') }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="amount">Amount:</label>
                                                                        <input type="number" class="form-control" id="amount" name="amount" value="{{ $data->amount }}">
                                                                    </div>
                                                                      <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                                      </div>
                                                                </form>
                                                      </div>

                                                    </div>
                                                  </div>
                                                </div>                
                                            @endforeach

                                            </tbody>
                                        </table>
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