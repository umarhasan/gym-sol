@extends('layouts.app')
<style>
    .form-control {
        border-radius: 2px;
    }

    
</style>
@if($latestSubscription->latest_expiration != '')
        @if($timeLeft <= 8)
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
                                <h4 class="text-black fs-20">  Members Fee  </h4>
                                <p class="fs-13 mb-0 text-black"> Unleash your potential with us - where every payment fuels your fitness journey. </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">

                            <div class="col-xl-4 col-lg-12 col-sm-12 animate__animated animate__backInUp">
                                <div class="card overflow-hidden" style="margin-bottom: 10px;">
                                    <div class="text-center p-3 overlay-box" style="background-image: url({{ asset('assets/images/big/img1.jpg') }}); background: #222b34;" >
                                        <div class="profile-photo">
                                        <img src="{{ asset('uploads/member/profile/' . $member->profile) }}" width="100" class="img-fluid rounded-circle" alt="">
                   
                                        <!-- <img src="{{ $member->image != '' ? $member->image : ($member->gender == 'male' ? asset('assets/male-placeholder.jpg') : asset('assets/female-placeholder.jpg')) }}" width="100" class="img-fluid rounded-circle" alt="" /> -->
                                        </div>
                                        <h3 class="mt-3 mb-1 text-white">{{ $member->name }}</h3>
                                        <p class="text-white mb-0">{{ $member->email }}</p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0"> Phone </span> <strong class="text-muted">{{ $member->phone }} </strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Dob</span> <strong class="text-muted"> {{ $member->dob }} </strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Gender</span> <strong class="text-muted"> {{ $member->gender }} </strong></li>
                                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Fees</span> <strong class="text-muted"> {{ $member->fees }} </strong></li>
                                        <li class="list-group-item d-flex justify-content-between" style="border-bottom: 0.2px solid rgba(0,0,0,0.1); width: 100%"> 
                                            @if($latestSubscription->latest_expiration != '')
                                                @if($timeLeft <= 8)
                                                    <span class="badge light badge-warning" style="width: 100%">
                                                        <i class="fa-duotone fa-timer mr-1"></i>
                                                        Subscription will expire in {{ $timeLeft }} days
                                                    </span>    
                                                @elseif(\Carbon\Carbon::parse($latestSubscription->latest_expiration)->gte(\Carbon\Carbon::now()))
                                                    <span class="badge light badge-primary" style="width: 100%">
                                                        <i class="fa-duotone fa-timer mr-1"></i>
                                                        Subscription will expire in {{ $timeLeft }} days
                                                    </span>     
                                                @else
                                                    <span class="badge light badge-danger" style="width: 100%">
                                                        <i class="fa-duotone fa-timer mr-1"></i>
                                                        Subscription is expired
                                                    </span>     
                                                @endif
                                            @else
                                                <span class="badge light badge-light" style="width: 100%">
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
                                    <div class="card-body">
                                        <div class="input-group input-group-md mb-3 mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Name</span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Member Name" readonly value="{{ $member->name }}">
                                        </div>

                                        <div class="input-group input-group-md mb-3 mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Phone</span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Member Phone" readonly value="{{ $member->phone }}">
                                        </div>

                                        <div class="input-group input-group-md mb-3 mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Amount</span>
                                            </div>
                                            <input type="number" class="form-control" placeholder="Amount" value="{{ $member->fees }}" >
                                        </div>
                                        <div class="input-group input-group-md mb-3 mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Expiry</span>
                                            </div>
                                            <input type="date" class="form-control flatpickr-01" placeholder="Expiry" value="">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" wire:click.prevent="takeFee()" class="btn btn-primary">
                                            <span wire:loading.remove wire:target="takeFee" style="font-size: 13px;"> <i class="fa-duotone fa-check-to-slot"></i> Submit & Continue </span>
                                        </button>
                                    </div>
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
    </div>    

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
    if(session != '') {
        initalizedExpiry();
    }

    function initalizedExpiry(){
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
</script>
@endsection

