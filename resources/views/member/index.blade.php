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
                                            <div class="pull-right">
                                                @can('member-create')
                                                    <a class="btn btn-primary" style="margin-bottom:5px"
                                                        href="{{ route('member.create') }}"> + Add Member</a>
                                                @endcan
                                            </div>
                                            <table id="example" class="table dataTable no-footer" role="grid"
                                                aria-describedby="order-listing_info">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Fees</th>
                                                        <th>Status</th>
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
                                                                <td>{{ $user->fees }}</td>
                                                                <td>
                                                                    @php
                                                                        $currentYear = date('Y');
                                                                        $memberSubscription = DB::table('fees')
                                                                            ->whereYear('expiry', $currentYear)
                                                                            ->where('user_id', $user->id)
                                                                            ->select(
                                                                                DB::raw(
                                                                                    'MAX(expiry) as latest_expiration',
                                                                                ),
                                                                            )
                                                                            ->first();

                                                                        if (isset($memberSubscription)) {
                                                                            $expired = Carbon\Carbon::now()->gte(
                                                                                Carbon\Carbon::parse(
                                                                                    $memberSubscription->latest_expiration,
                                                                                ),
                                                                            );
                                                                        }
                                                                    @endphp
                                                                    @if (isset($memberSubscription->latest_expiration))
                                                                        @if ($expired)
                                                                            <span
                                                                                style="width: 100% white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display:flex; justify-content:center"
                                                                                class="badge light badge-danger">
                                                                                <i
                                                                                    class="fa-duotone fa-clock mr-1 text-danger"></i>
                                                                                &nbsp; Subscription has expired.
                                                                            </span>
                                                                        @else
                                                                            @if (Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)) <= 8)
                                                                                <span
                                                                                    style="width: 100% white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display:flex; justify-content:center"
                                                                                    class="badge light badge-warning">
                                                                                    <i
                                                                                        class="fa-duotone fa-clock mr-1 text-warning"></i>
                                                                                    &nbsp; Subscription will expire in
                                                                                    {{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)) }}
                                                                                    days
                                                                                </span>
                                                                            @elseif(Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)) > 8)
                                                                                <span
                                                                                    style="width: 100% white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display:flex; justify-content:center"
                                                                                    class="badge light badge-primary">
                                                                                    <i
                                                                                        class="fa-duotone fa-clock mr-1 text-primary"></i>
                                                                                    &nbsp;
                                                                                    Subscription will expire in
                                                                                    {{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($memberSubscription->latest_expiration)) }}
                                                                                    days.
                                                                                </span>
                                                                            @else
                                                                                <span
                                                                                    style="width: 100% white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display:flex; justify-content:center"
                                                                                    class="badge light badge-light">
                                                                                    <i
                                                                                        class="fa-duotone fa-clock mr-1 text-light"></i>
                                                                                    &nbsp; Not Paid Yet!
                                                                                </span>
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        <span
                                                                            style="width: 100% white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display:flex; justify-content:center"
                                                                            class="badge light badge-light">
                                                                            <i
                                                                                class="fa-duotone fa-clock mr-1 text-light"></i>
                                                                            &nbsp; Not Paid Yet!
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <a class="btn-warning btn-a btn-sm"
                                                                            href="{{ route('member.profile', $user->id) }}"><i
                                                                                class="fa fa-eye"></i></a> &nbsp;

                                                                        @can('member-edit')
                                                                            <a class="btn-primary btn-a btn-sm"
                                                                                href="{{ route('member.edit', $user->id) }}"><i
                                                                                    class="fa fa-edit"></i></a> &nbsp;
                                                                        @endcan

                                                                        <a class="btn-primary btn-a btn-sm"
                                                                            href="{{ route('fees.create', $user->id) }}"><i
                                                                                class="fa fa-file-invoice-dollar"></i></a>
                                                                        &nbsp;

                                                                        @can('member-delete')
                                                                            <form method="post"
                                                                                action="{{ route('member.destroy', $user->id) }}">
                                                                                @csrf
                                                                                @method('delete')
                                                                                <button type="submit"
                                                                                    onclick="return confirm('Are You Sure Want To Delete This.??')"
                                                                                    type="button"
                                                                                    class="btn-danger btn-b btn-sm"><i
                                                                                        class="fa fa-trash"></i></button>
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
                    </section>
                </div>
            </div>
        </div>
    @endsection
