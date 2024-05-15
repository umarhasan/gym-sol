@extends('layouts.app')
<style>
    .form-control {
        border-radius: 2px;
    }

    .height {
        height: 50px !important;
    }
</style>
@if ($latestSubscription->latest_expiration != '')
    @if ($timeLeft <= 8)
        <style>
            .overlay-box:after {
                background-color: #FFBC11 !important;
            }
        </style>
    @elseif(\Carbon\Carbon::parse($latestSubscription->latest_expiration)->gte(\Carbon\Carbon::now()))
        <style>
            .overlay-box:after {
                background-color: #0B2A97 !important;
            }
        </style>
    @else
        <style>
            .overlay-box:after {
                background-color: #F94687 !important;
            }
        </style>
    @endif
@else
    <style>
        .overlay-box:after {
            background-color: #F4F5F9 !important;
        }

        .overlay-box h3 {
            color: black !important;
        }

        .overlay-box p {
            color: black !important;
        }
    </style>
@endif
@section('content')

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <div class="card row" style="background-color: transparent">
                        <div class="card-header d-block pb-0 border-0">
                            <div class="d-sm-flex flex-wrap justify-content-between align-items-center d-block mb-md-3 mb-0">
                                <div class="mr-auto pr-3 mb-3">
                                    <h4 class="text-black fs-20"> Members Fee </h4>
                                    <p class="fs-13 mb-0 text-black"> Unleash your potential with us - where every payment
                                        fuels your fitness journey. </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body row">

                            <div class="col-xl-4 col-lg-12 col-sm-12 animate__animated animate__backInUp">
                                <div class="card overflow-hidden" style="margin-bottom: 10px;">
                                    <div class="text-center p-3 overlay-box"
                                        style="background-image: url({{ asset('assets/images/big/img1.jpg') }}); background: #222b34;">
                                        <div class="profile-photo">
             @if($member->profile)
                        <img src="{{ asset('uploads/member/profile/' . $user->profile) }}" alt="" class="rounded-circle" style="width: 100px; height: 100px;">
                    @else
                        <img src="{{ asset('admin/images/logo/profile.jpg') }}" alt="Default Profile Image" class="rounded-circle" style="width: 100px; height: 100px;">
                    @endif
                                        </div>
                                        <h3 class="mt-3 mb-1 text-white">{{ $member->name }}</h3>
                                        <p class="text-white mb-0">{{ $member->email }}</p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">
                                                Phone </span> <strong class="text-muted">{{ $member->phone }} </strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span
                                                class="mb-0">Dob</span> <strong class="text-muted"> {{ $member->dob }}
                                            </strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span
                                                class="mb-0">Gender</span> <strong class="text-muted">
                                                {{ $member->gender }} </strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span
                                                class="mb-0">Fees</span> <strong class="text-muted"> {{ $member->fees }}
                                            </strong></li>
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
                                    <br />
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-md-8 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Collect Fee</h4>
                                    </div>
                                    <form method="POST" action="{{ route('fees.store') }}">
                                        @csrf

                                        <div class="card-body">
                                            <div class="input-group input-group-md mb-3 mt-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Name</span>
                                                </div>
                                                <input type="hidden" name="userId" value="{{ $member->id }}" >
                                                <input type="text" name="name" class="form-control height"
                                                    placeholder="Member Name" readonly value="{{ $member->name }}">
                                            </div>

                                            <div class="input-group input-group-md mb-3 mt-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Phone</span>
                                                </div>
                                                <input type="text" name="phone" class="form-control height"
                                                    placeholder="Member Phone" readonly value="{{ $member->phone }}">
                                            </div>

                                            <div class="input-group input-group-md mb-3 mt-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Amount</span>
                                                </div>
                                                <input type="number" name="amount" class="form-control height"
                                                    placeholder="Amount" value="{{ $member->fees }}">
                                            </div>
                                            <div class="input-group input-group-md mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="expiry_month">Select Months</label>
                                                </div>
                                                <select class="form-control height" id="expiry_month" name="date">
                                                    <option selected>Select...</option>
                                                    <option value="1">01 month</option>
                                                    <option value="3">03 months</option>
                                                    <option value="6">06 months</option>
                                                    <option value="12">12 months</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="modal-footer">
                                            <button type="submit"  class="btn btn-primary">
                                                <span wire:loading.remove wire:target="takeFee" style="font-size: 13px;">
                                                    <i class="fa-duotone fa-check-to-slot"></i> Submit & Continue </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a class="nav-link  ai-icon d-md-none" href="{{ route('member.index') }}">
                        <span><i class="fa-thin fa-chevrons-left  text-bold text-primary"></i> </span>
                        <div class="pulse-css"></div>
                    </a>
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
        
        
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
             
            window.addEventListener('fees-collected-sucessfully', event => {
                toastr.success(`${event.detail.body}`, `${event.detail.title}`, {
                    timeOut: 500000000,
                    closeButton: !0,
                    debug: !1,
                    newestOnTop: !0,
                    progressBar: !0,
                    positionClass: "toast-top-right",
                    preventDuplicates: !0,
                    onclick: null,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: !1,
                });
            });

            window.addEventListener('member-loaded', event => {
                initalizedExpiry();
            });

            var session = "{{ \Session::get('selectedMember') }}";
            if (session != '') {
                initalizedExpiry();
            }

            function initalizedExpiry() {
                setTimeout(() => {
                    $(".flatpickr-01").flatpickr({
                        // minDate: "today",
                        // maxDate: @this.date,
                        theme: "dark",
                        defaultDate: @this.date,
                        onReady: function(selectedDates, dateStr, instance) {
                            @this.date = dateStr;
                        },
                        onChange: function(selectedDates, dateStr, instance) {
                            @this.date = dateStr;
                        }
                    });
                }, 1000);
            }
            
            function showCustomInput(select) {
                var customInput = document.getElementById('customInput');
                if (select.value === 'custom') {
                    customInput.style.display = 'block';
                } else {
                    customInput.style.display = 'none';
                }
            }    
        </script>
    @endsection
