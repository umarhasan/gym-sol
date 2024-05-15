@extends('layouts.app')
<style>
    .pagination,
    .jsgrid .jsgrid-pager {
        display: flex;
        padding-left: 350px;
        margin-top: -25px;
        list-style: none;
        border-radius: 0.25rem;
    }
    .light.badge-warning {
    background-color: #fff5dd;
    color: #FFBC11;
}

.badge-warning {
    background-color: #FFBC11;
}
.badge {
    line-height: 1.5;
    border-radius: 1.25rem;
    font-size: 14px;
    font-weight: 600;
    padding: 4px 10px;
    border: 1px solid transparent;
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
                                <h1>Users Management</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Unpaid Member</li>
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
                                        <h3 class="card-title">Unpaid Member</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example" class="table dataTable no-footer" role="grid"
                                            aria-describedby="order-listing_info">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($unPaidMembers as $data)
                                                <tr>
                                                    <td>
                                                        @if($data->image)
                                                        <a href="{{route('member.profile',['id' => $data->userId])}}"
                                                            class="btn btn-xs btn-link" target="_blank"><img
                                                                src="{{ asset('uploads/user/' . $data->image) }}" alt=""
                                                                class="rounded-circle" style="width: 50px; height:50px;">
                                                            {{$data->name}} </a>
                                                        @else
                                                        <a href="{{route('member.profile',['id' => $data->userId])}}"
                                                            class="btn btn-xs btn-link" target="_blank"><img
                                                                src="{{ asset('admin/images/profile.jpg') }}"
                                                                class="rounded-circle" style="width: 50px; height:50px;">
                                                            {{$data->name}} </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="fs-12">{{$data->phone}}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge light badge-warning">
                                                            <i class="fa fa-circle text-warning mr-1" aria-hidden="true"></i>
                                                             Un Paid
                                                        </span>                        
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $unPaidMembers->links('custom_pagiantion') }}
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
