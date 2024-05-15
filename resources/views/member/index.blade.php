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
                                <h1>Member Management</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Member Management</li>
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
                                        <h3 class="card-title">Member List</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="pull-right">
                                                    @can('member-create')
                                                    <a class="btn btn-primary" style="margin-bottom:5px" href="{{ route('member.create') }}"> + Add Member</a>
                                                    @endcan
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <form action="{{ route('members.import') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group mb-0">
                                                        <label for="file" class="mr-2">Choose CSV File:</label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="file" name="file">
                                                            <div class="input-group-append">
                                                                <a href="{{ route('members.download') }}" class="btn btn-success" download>
                                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                                </a>&nbsp;<button type="submit" class="btn btn-primary">Import</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        </br>
                                        <div style="max-height: 50; overflow-y: auto;">
                                            <table id="example" class="table dataTable no-footer" role="grid" aria-describedby="order-listing_info">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Fees</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($data)
                                                    @php
                                                    $id = 1;
                                                    @endphp
                                                    @foreach ($data as $key => $user)
                                                    <tr>
                                                        <td>{{ $id++ }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->phone }}</td>
                                                        <td>{{ isset($user->Fees->amount) ? $user->Fees->amount : 0 }}</td>
                                                        <!--<td>-->
                                                        <!--    @php-->
                                                        <!--        $currentYear = date('Y');-->
                                                        <!--        $memberSubscription = DB::table('fees')-->
                                                        <!--            ->whereYear('expiry', $currentYear)-->
                                                        <!--            ->where('user_id', $user->Fees->user_id)-->
                                                        <!--            ->select(DB::raw('MAX(CONVERT_TZ(expiry,"+00:00","+05:00")) as latest_expiration'),-->
                                                        <!--                      DB::raw('MAX(CONVERT_TZ(date,"+00:00","+05:00")) as date_expiration'))-->
                                                        <!--            ->whereNull('deleted_at')->first();                                      -->
                                                        <!--        if (isset($memberSubscription)) {-->
                                                        <!--            $expired = Carbon\Carbon::parse($memberSubscription->date_expiration)->gte(-->
                                                        <!--                Carbon\Carbon::parse($memberSubscription->latest_expiration)-->
                                                        <!--            );-->
                                                        <!--        }-->
                                                        <!--    @endphp-->
                                                            
                                                        <!--    @if (isset($memberSubscription->latest_expiration))-->
                                                        <!--        @if ($expired)-->
                                                        <!--            <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-danger" data-toggle="tooltip" data-placement="top" title="Subscription has expired - {{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)) }} days">-->
                                                        <!--                <div style="display: flex; align-items: center;">-->
                                                        <!--                    <i class="fa fa-clock mr-1 text-white"></i>-->
                                                        <!--                    <?php $timeLeft =  Carbon\Carbon::parse($memberSubscription->date_expiration)->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)->setTimezone('Asia/Karachi')); ?>-->
                                                        <!--                    <span>&nbsp;Subscription has been expired {{ ($timeLeft ?? 0) > 0 ? "-" . ($timeLeft ?? 0) : ($timeLeft ?? 0) }} days left </span>-->
                                                        <!--                </div>-->
                                                                        
                                                        <!--            </span>-->
                                                        <!--        @else-->
                                                        <!--            @php-->
                                                        <!--                $daysUntilExpiration = Carbon\Carbon::parse($memberSubscription->date_expiration)->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)->setTimezone('Asia/Karachi'));-->
                                                                        
                                                        <!--                // Adjusting expiration message based on the number of days-->
                                                        <!--                if ($daysUntilExpiration == 1) {-->
                                                        <!--                    $expirationMessage = "1 day";-->
                                                        <!--                } else {-->
                                                        <!--                    $expirationMessage = "$daysUntilExpiration days";-->
                                                        <!--                }-->
                                                        <!--            @endphp-->
                                                                    
                                                        <!--            @if ($daysUntilExpiration <= 0)-->
                                                        <!--                <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-danger">-->
                                                        <!--                    <i class="fa fa-clock mr-1 text-white"></i>-->
                                                        <!--                    &nbsp; Subscription has expired {{ abs($daysUntilExpiration) }} days ago -->
                                                        <!--                </span>-->
                                                        <!--            @elseif ($daysUntilExpiration <= 3)-->
                                                        <!--                <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-danger">-->
                                                        <!--                    <i class="fa fa-clock mr-1 text-white"></i>-->
                                                        <!--                    &nbsp; Subscription has been expired {{ $expirationMessage }} ago -->
                                                        <!--                </span>-->
                                                        <!--            @elseif ($daysUntilExpiration <= 8)-->
                                                        <!--                <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-warning">-->
                                                        <!--                    <i class="fa fa-clock mr-1 text-white"></i>-->
                                                        <!--                    &nbsp; Subscription will expire in {{ $expirationMessage }} -->
                                                        <!--                </span>-->
                                                        <!--            @else-->
                                                        <!--                <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-primary">-->
                                                        <!--                    <i class="fa fa-clock mr-1 text-white"></i>-->
                                                        <!--                    &nbsp; Subscription will expire in {{ $expirationMessage }}-->
                                                        <!--                </span>-->
                                                        <!--            @endif-->
                                                        <!--        @endif-->
                                                        <!--    @else-->
                                                        <!--        <span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: center;" class="badge light badge-light">-->
                                                        <!--            <i class="fa fa-clock mr-1 text-light"></i>-->
                                                        <!--            &nbsp; Not Paid Yet!-->
                                                        <!--        </span>-->
                                                        <!--    @endif-->
                                                        <!--</td>-->
                                                        <!--<td>-->
                                                        <!--        @php-->
                                                        <!--        $currentYear = date('Y');-->
                                                        <!--        $memberSubscription = DB::table('fees')-->
                                                        <!--            ->whereYear('expiry', $currentYear)-->
                                                        <!--            ->where('user_id', $user->Fees->user_id)-->
                                                        <!--            ->select(DB::raw('MAX(CONVERT_TZ(expiry,"+00:00","+05:00")) as latest_expiration'),-->
                                                        <!--                      DB::raw('MAX(CONVERT_TZ(date,"+00:00","+05:00")) as date_expiration'))->whereNull('deleted_at')->first();                                      -->
                                                        <!--        if (isset($memberSubscription)) {-->
                                                        <!--            $expired = Carbon\Carbon::parse($memberSubscription->date_expiration)->gte(-->
                                                        <!--                Carbon\Carbon::parse($memberSubscription->latest_expiration)-->
                                                        <!--            );-->
                                                        <!--        }-->
                                                        <!--    @endphp-->
                                                            
                                                        <!--    @if (isset($memberSubscription->latest_expiration))-->
                                                        <!--        @if ($expired)-->
                                                        <!--         <?php $timeLeft =  Carbon\Carbon::parse($memberSubscription->date_expiration)->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)->setTimezone('Asia/Karachi')); ?>-->
                                                        <!--            <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}&text=Subscription has expired {{ ($timeLeft ?? 0) > 0 ? "-" . ($timeLeft ?? 0) : ($timeLeft ?? 0) }} days left" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>-->
                                                        <!--        @else-->
                                                        <!--            @php-->
                                                        <!--                $daysUntilExpiration = Carbon\Carbon::parse($memberSubscription->date_expiration)->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)->setTimezone('Asia/Karachi'));-->
                                                                        
                                                        <!--                // Adjusting expiration message based on the number of days-->
                                                        <!--                if ($daysUntilExpiration == 1) {-->
                                                        <!--                    $expirationMessage = "1 day";-->
                                                        <!--                } else {-->
                                                        <!--                    $expirationMessage = "$daysUntilExpiration days";-->
                                                        <!--                }-->
                                                        <!--            @endphp-->
                                                                    
                                                        <!--            @if ($daysUntilExpiration <= 0)-->
                                                        <!--                 <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}&text=Subscription has expired {{ $expirationMessage }} days ago" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>-->
                                                                         
                                                                        
                                                        <!--            @elseif ($daysUntilExpiration <= 3)-->
                                                        <!--            <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}&text=Subscription has been expired {{ $expirationMessage }} ago" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>-->
                                                                        
                                                        <!--            @elseif ($daysUntilExpiration <= 8)-->
                                                        <!--                <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}&text=Subscription will expire in {{ $expirationMessage }}" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>-->
                                                                       
                                                        <!--            @else-->
                                                        <!--                <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}&text=Subscription will expire in {{ $expirationMessage }}" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>-->
                                                                       
                                                        <!--            @endif-->
                                                        <!--        @endif-->
                                                        <!--    @else-->
                                                        <!--     <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}&text=Not paid Yet!" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>-->
                                                             
                                                        <!--    @endif  -->
                                                        <!--</td>-->
                                                        <td>
                                                            @php
                                                                $currentYear = date('Y');
                                                                $memberSubscription = DB::table('fees')
                                                                    ->whereYear('expiry', $currentYear)
                                                                    ->where('user_id', optional($user->Fees)->user_id)
                                                                    ->select(DB::raw('MAX(CONVERT_TZ(expiry,"+00:00","+05:00")) as latest_expiration'),
                                                                              DB::raw('MAX(CONVERT_TZ(date,"+00:00","+05:00")) as date_expiration'))
                                                                    ->whereNull('deleted_at')
                                                                    ->first();                                      
                                                                if ($memberSubscription) {
                                                                    $expired = Carbon\Carbon::parse($memberSubscription->date_expiration)->gte(
                                                                        Carbon\Carbon::parse($memberSubscription->latest_expiration)
                                                                    );
                                                                }
                                                            @endphp
                                                            
                                                            @if ($memberSubscription && isset($memberSubscription->latest_expiration))
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
                                                                    ->where('user_id', optional($user->Fees)->user_id)
                                                                    ->select(DB::raw('MAX(CONVERT_TZ(expiry,"+00:00","+05:00")) as latest_expiration'),
                                                                              DB::raw('MAX(CONVERT_TZ(date,"+00:00","+05:00")) as date_expiration'))
                                                                    ->whereNull('deleted_at')
                                                                    ->first();                                      
                                                                if ($memberSubscription) {
                                                                    $expired = Carbon\Carbon::parse($memberSubscription->date_expiration)->gte(
                                                                        Carbon\Carbon::parse($memberSubscription->latest_expiration)
                                                                    );
                                                                }
                                                            @endphp
                                                            
                                                            @if ($memberSubscription && isset($memberSubscription->latest_expiration))
                                                                @if ($expired)
                                                                    <?php $timeLeft =  Carbon\Carbon::parse($memberSubscription->date_expiration)->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)->setTimezone('Asia/Karachi')); ?>
                                                                    <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}&text=Subscription has expired {{ ($timeLeft ?? 0) > 0 ? "-" . ($timeLeft ?? 0) : ($timeLeft ?? 0) }} days left" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
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
                                                                        <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}&text=Subscription has expired {{ $expirationMessage }} days ago" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
                                                                    @elseif ($daysUntilExpiration <= 3)
                                                                        <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}&text=Subscription has been expired {{ $expirationMessage }} ago" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
                                                                    @elseif ($daysUntilExpiration <= 8)
                                                                        <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}&text=Subscription will expire in {{ $expirationMessage }}" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
                                                                    @else
                                                                        <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}&text=Subscription will expire in {{ $expirationMessage }}" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                <a href="https://api.whatsapp.com/send?phone={{ $user->phone }}&text=Not paid Yet!" target="_blank"><img src="{{ asset('admin/images/whatsapp.png') }}" alt="WhatsApp"></a>
                                                            @endif  
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a class="btn-warning btn-a btn-sm" href="{{ route('member.profile', $user->id) }}"><i class="fa fa-eye"></i></a> &nbsp;

                                                                @can('member-edit')
                                                                <a class="btn-primary btn-a btn-sm" href="{{ route('member.edit', $user->id) }}"><i class="fa fa-edit"></i></a> &nbsp;
                                                                @endcan

                                                                <a class="btn-primary btn-a btn-sm" href="{{ route('fees.create', $user->id) }}"><i class="fa fa-file-invoice-dollar"></i></a>
                                                                &nbsp;

                                                                @can('member-delete')
                                                                <form method="post" action="{{ route('member.destroy', $user->id) }}">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" onclick="return confirm('Are You Sure Want To Delete This.??')" type="button" class="btn-danger btn-b btn-sm"><i class="fa fa-trash"></i></button>
                                                                </form>
                                                                @endcan
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            {{ $data->links('custom_pagiantion') }}
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