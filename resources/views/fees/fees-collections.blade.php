@extends('layouts.app')

@section('content')
    <style>
        .pagination,
        .jsgrid .jsgrid-pager {
            display: flex;
            padding-left: 350px;
            margin-top: -25px;
            list-style: none;
            border-radius: 0.25rem;
        }

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
    </style>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>Fees Collections</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active">Fees Collections</li>
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
                                            <h3 class="card-title">Fees Collections</h3>
                                        </div>
                                        <div class="card-body">
                                            <div style="max-height: 50; overflow-y: auto;">
                                                <table id="example" class="table dataTable no-footer" role="grid"
                                                    aria-describedby="order-listing_info">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Name</th>
                                                            <th>Phone</th>
                                                            <th>Amount</th>
                                                            <th>Expiry</th>
                                                            <th>Status</th>
                                                            <th></th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($collections)
                                                            @php $i = 1; @endphp
                                                            @foreach ($collections as $index => $data)
                                                                @php $i++; @endphp
                                                            <tr>
                                                                <td>
                                                                    <span class="fs-14"> {{ $i }} </span>
                                                                </td>
                                                                <td>
                                                                    <span class="fs-14"> {{ $data->name }} </span>
                                                                </td>
                                                                <td>
                                                                    <span class="fs-14"> {{ $data->phone }} </span>
                                                                </td>
                                                                <td>
                                                                    <span class="fs-14">
                                                                        {{ isset($data->latest_amount) ? $data->latest_amount : 0 }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="fs-14">
                                                                        {{ \Carbon\Carbon::parse($data->latest_expiry)->format('Y F d') }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                @php
                                                                    $currentYear = date('Y');
                                                                    $memberSubscription = DB::table('fees')
                                                                        ->whereYear('expiry', $currentYear)
                                                                        ->where('user_id', $data->id)
                                                                        ->whereNull('deleted_at')
                                                                        ->select(DB::raw('MAX(CONVERT_TZ(expiry,"+00:00","+05:00")) as latest_expiration'),
                                                                                  DB::raw('MAX(CONVERT_TZ(date,"+00:00","+05:00")) as date_expiration'))
                                                                        ->first();                                      
                                                                    if (isset($memberSubscription)) {
                                                                        $expired = Carbon\Carbon::parse($memberSubscription->date_expiration)->gte(
                                                                            Carbon\Carbon::parse($memberSubscription->latest_expiration)
                                                                        );
                                                                    }
                                                                @endphp
                                                                
                                                                @if (isset($memberSubscription->latest_expiration))
                                                                    @if ($expired)
                                                                        <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-danger" data-toggle="tooltip" data-placement="top" title="Subscription has expired - {{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)) }} days">
                                                                            <div style="display: flex; align-items: center;">
                                                                                <i class="fa fa-clock mr-1 text-white"></i>
                                                                                <?php $timeLeft =  Carbon\Carbon::parse($memberSubscription->date_expiration)->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)->setTimezone('Asia/Karachi')); ?>
                                                                                <span>&nbsp;Subscription has been expired {{ ($timeLeft ?? 0) > 0 ? "-" . ($timeLeft ?? 0) : ($timeLeft ?? 0) }} days left </span>
                                                                            </div>
                                                                            
                                                                        </span>
                                                                    @else
                                                                        @php
                                                                            $daysUntilExpiration = Carbon\Carbon::parse($memberSubscription->date_expiration)->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)->setTimezone('Asia/Karachi'));
                                                                            
                                                                            // Adjusting expiration message based on the number of days
                                                                            if ($daysUntilExpiration == 1) {
                                                                                $expirationMessage = "1 day";
                                                                            } else {
                                                                                $expirationMessage = "$daysUntilExpiration days";
                                                                            }
                                                                        @endphp
                                                                        
                                                                        @if ($daysUntilExpiration <= 0)
                                                                            <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-danger">
                                                                                <i class="fa fa-clock mr-1 text-white"></i>
                                                                                &nbsp; Subscription has expired {{ abs($daysUntilExpiration) }} days ago 
                                                                            </span>
                                                                        @elseif ($daysUntilExpiration <= 3)
                                                                            <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-danger">
                                                                                <i class="fa fa-clock mr-1 text-white"></i>
                                                                                &nbsp; Subscription has been expired {{ $expirationMessage }} ago 
                                                                            </span>
                                                                        @elseif ($daysUntilExpiration <= 8)
                                                                            <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-warning">
                                                                                <i class="fa fa-clock mr-1 text-white"></i>
                                                                                &nbsp; Subscription will expire in {{ $expirationMessage }} 
                                                                            </span>
                                                                        @else
                                                                            <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-primary">
                                                                                <i class="fa fa-clock mr-1 text-white"></i>
                                                                                &nbsp; Subscription will expire in {{ $expirationMessage }}
                                                                            </span>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-light">
                                                                        <i class="fa fa-clock mr-1 text-light"></i>
                                                                        &nbsp; Not Paid Yet!
                                                                    </span>
                                                                @endif
                                                    </td>
                                                                <td>
                                                                    @php
                                                                    $currentYear = date('Y');
                                                                    $memberSubscription = DB::table('fees')
                                                                        ->whereYear('expiry', $currentYear)
                                                                         ->where('user_id', $data->id)
                                                                         ->whereNull('deleted_at')
                                                                        ->select(DB::raw('MAX(CONVERT_TZ(expiry,"+00:00","+05:00")) as latest_expiration'),
                                                                                  DB::raw('MAX(CONVERT_TZ(date,"+00:00","+05:00")) as date_expiration'))
                                                                        ->first();                                      
                                                                    if (isset($memberSubscription)) {
                                                                        $expired = Carbon\Carbon::parse($memberSubscription->date_expiration)->gte(
                                                                            Carbon\Carbon::parse($memberSubscription->latest_expiration)
                                                                        );
                                                                    }
                                                                @endphp
                                                                
                                                                @if (isset($memberSubscription->latest_expiration))
                                                                    @if ($expired)
                                                                     <?php $timeLeft =  Carbon\Carbon::parse($memberSubscription->date_expiration)->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)->setTimezone('Asia/Karachi')); ?>
                                                                        <a href="https://api.whatsapp.com/send?phone={{ $data->phone }}&text=Subscription has expired {{ ($timeLeft ?? 0) > 0 ? "-" . ($timeLeft ?? 0) : ($timeLeft ?? 0) }} days left" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
                                                                    @else
                                                                        @php
                                                                            $daysUntilExpiration = Carbon\Carbon::parse($memberSubscription->date_expiration)->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)->setTimezone('Asia/Karachi'));
                                                                            if ($daysUntilExpiration == 1) {
                                                                                $expirationMessage = "1 day";
                                                                            } else {
                                                                                $expirationMessage = "$daysUntilExpiration days";
                                                                            }
                                                                        @endphp
                                                                        @if ($daysUntilExpiration <= 0)
                                                                             <a href="https://api.whatsapp.com/send?phone={{ $data->phone }}&text=Subscription has expired {{ $expirationMessage }} days ago" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
                                                                        @elseif ($daysUntilExpiration <= 3)
                                                                        <a href="https://api.whatsapp.com/send?phone={{ $data->phone }}&text=Subscription has been expired {{ $expirationMessage }} ago" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
                                                                        @elseif ($daysUntilExpiration <= 8)
                                                                            <a href="https://api.whatsapp.com/send?phone={{ $data->phone }}&text=Subscription will expire in {{ $expirationMessage }}" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
                                                                        @else
                                                                            <a href="https://api.whatsapp.com/send?phone={{ $data->phone }}&text=Subscription will expire in {{ $expirationMessage }}" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                 <a href="https://api.whatsapp.com/send?phone={{ $data->phone }}&text=Not paid Yet!" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
                                                                 
                                                                @endif  
                                                    </td>   
                                                                <td>
                                                                            <a class="btn btn-warning btn-a"
                                                                                href="{{ route('fees.create', $data->id) }}"><i
                                                                                    class="fa fa-file-invoice-dollar"></i> Receive Payment Now</a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                {{ $collections->links('pagination::bootstrap-4') }}
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
