@extends('layouts.app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <style>
                @media print {
                    body * {
                        visibility: hidden;
                    }

                    .main-panel,
                    .main-panel * {
                        visibility: visible;
                    }

                    .main-panel {
                        position: absolute;
                        left: 0;
                        top: 0;
                    }

                    #print-button {
                        display: none;
                    }
                }
            </style>

            <div class="row">
                <div class="content-wrapper">
                    @php
                        $actual_link =
                            (empty($_SERVER['HTTPS']) ? 'http' : 'https') .
                            "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    @endphp
                    <div class="row" style="display: flex; justify-content: center; align-items: center">
                        <div class="col-md-8 col-sm-12 card mt-5" style="border-radius: 0px;">
                            <a href="{{ route('member.index') }}" id="back-button"
                                style="border-radius: 0px; width: 120px; margin-left: -2%; border-radius: 0px 0px 40px 0px"
                                class="btn btn-sm btn-primary"> <i class="fa-regular fa-chevrons-left"></i> Back </a>
                            <div class="card-header" style="padding: 0px;">
                                <div class="logo"
                                    style="width: 20%; display: flex; justify-content: space-around; align-items: flex-end">
                                    <img style="width: 100%; height: auto"
                                        src="{{ $clubSetting->logo ?? asset('assets/gymsol-logo-mini.png') }}"
                                        alt="">
                                </div>
                                <h4 class="text text-black-50 text-bold"
                                    style="display: flex; justify-content: flex-end; align-items: flex-start; flex-direction: column; font-weight: bold;">
                                    <div class="GYM"> <span class="text text-info">{{ $clubSetting->gym_name }}</span>
                                    </div>
                                    <div class="invoice text-info"> Invoice <span class="text text-capitalize text-black"
                                            style="font-weight: 200; font-size: 16px; margin-top:5px;">#{{ $data->invoice_url }}</span>
                                    </div>
                                </h4>
                            </div>
                            <div class="card-body" style="padding: 0px">
                                <div class="row">
                                    <div class=" col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card" style="box-shadow: none; ">
                                            <div class="card-body pb-0"
                                                style="box-shadow: none; border: 0.5px solid rgba(0,0,0,0.1); border-right: none;">
                                                <h4 class="fw-bolder">From</h4>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                                        <strong>GYM</strong>
                                                        <span class="mb-0">{{ $clubSetting->gym_name }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                                        <strong>Owner</strong>
                                                        <span class="mb-0"> {{ $clubSetting->owner_name }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                                        <strong>Contact No </strong>
                                                        <span class="mb-0">{{ $clubSetting->owner_phone }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

                                        <div class="card" style="box-shadow: none;">
                                            <div class="card-body pb-0"
                                                style="box-shadow: none; border: 0.5px solid rgba(0,0,0,0.1)">
                                                <h4 class="fw-bolder">To</h4>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                                        <strong>Expense By</strong>
                                                        <span class="mb-0">{{ $data->expense_by }}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                                        <strong>Paid To</strong>
                                                        <span class="mb-0">{{ $data->paid_to }}</span>
                                                    </li>

                                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                                        <strong>Amount</strong>
                                                        <span class="mb-0">{{ $data->amount }}</span>
                                                    </li>

                                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                                        <strong>Date</strong>
                                                        <span class="mb-0">{{ $data->date }}</span>
                                                    </li>

                                                    <li id="print-button"
                                                        class="list-group-item d-flex px-0 justify-content-between">
                                                        <strong></strong>
                                                        <div class="col-4 pt-3 pb-3 border-right">
                                                            <a target="_blank"
                                                                href="https://wa.me/send?phone={{ $clubSetting->active_whatsapp_no }}&amp;text=Thank you for making payment in {{ $clubSetting->gym_title }}, Here is your invoice Link  :  "
                                                                class="btn btn-xs btn-link" style="border-radius: 0px">
                                                                <h3 class="mb-1 text-primary"><i
                                                                        class="fab fa-whatsapp"></i></h3>
                                                                <span> Send </span>
                                                            </a>
                                                        </div>
                                                        <div class="col-4 pt-3 pb-3 border-right">
                                                            <a href="mailto:" class="btn btn-xs btn-link"
                                                                style="border-radius: 0px">
                                                                <h3 class="mb-1 text-primary"><i
                                                                        class="fas fa-envelope"></i></h3>
                                                                <span>
                                                                    Mail
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="col-4 pt-3 pb-3">
                                                            <button onclick="printInvoice()" class="btn btn-xs btn-link"
                                                                style="border-radius: 0px">
                                                                <h3 class="mb-1 text-primary"><i
                                                                        class="fas fa-print"></i></h3>
                                                                <span>
                                                                    Print
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <script>
            function printInvoice() {
                window.print();
                return false; // prevent the default behavior of the button
            }
        </script>
    @endsection
