<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @media print {
            .card-footer, .alert-dismissible, #back-button {
                display: none !important;
            }
        }

        .logo img {
            width: 80px; /* Adjust the logo width as needed */
            height: auto;
        }

        .invoice-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .invoice-number {
            font-size: 18px;
        }
    </style>
    @php
        $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    @endphp
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8 col-sm-12 card" style="border-radius: 0px;">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <!-- Back button -->
                            <a href="{{ url('member') }}" id="back-button" class="btn btn-primary">
                                <i class="fas fa-chevron-left"></i> Back
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <!-- Logo here -->
                            <div class="logo">
                                <img src="{{ asset('uploads/club-logo/' . $clubSetting->logo) ?? asset('assets/gymsol-logo-mini.png') }}" alt="">
                            </div>
                        </div>
                        
                    </div>
                    <div class="text-center">
                        <div class="invoice-header">
                            {{ $clubSetting->gym_name }}
                        </div>
                        <div class="invoice-number">
                            Invoice #{{ $data->invoice_url }}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="fw-bolder">From</h4>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>GYM</strong>
                                            <span>{{ $clubSetting->gym_title }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Owner</strong>
                                            <span>{{ $clubSetting->owner_name }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Contact No</strong>
                                            <span>{{ $clubSetting->owner_phone }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="fw-bolder">To</h4>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Name</strong>
                                            <span>{{ $data->name }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Phone</strong>
                                            <span>{{ $data->phone }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Issued On</strong>
                                            <span>{{ $data->date }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Expire On</strong>
                                            <span>{{ $data->expiry }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer pt-0 pb-0 text-center"
                                    style="box-shadow: none; border: 0.5px solid rgba(0,0,0,0.1)">
                                    <div class="row">
                                        <div class="col-4 pt-3 pb-3 border-right">
                                            <!-- WhatsApp icon and action -->
                                            <a target="_blank"
                                                href="https://wa.me/send?phone={{ $data->phone }}&amp;text=Thank you for making payment in {{ $clubSetting->gym_title }}, Here is your invoice Link :  {{ $actual_link }}"
                                                class="btn btn-xs btn-link" style="border-radius: 0px">
                                                <i class="fab fa-whatsapp"></i>
                                                <span> WhatsApp </span>
                                            </a>
                                        </div>
                                        <div class="col-4 pt-3 pb-3 border-right">
                                            <!-- Mail icon and action -->
                                            <a href="mailto:{{ $data->email }}" class="btn btn-xs btn-link"
                                                style="border-radius: 0px">
                                                <i class="fas fa-envelope"></i>
                                                <span> Mail </span>
                                            </a>
                                        </div>
                                        <div class="col-4 pt-3 pb-3">
                                            <!-- Print icon and action -->
                                            <button onclick="printInvoice()" class="btn btn-xs btn-link"
                                                style="border-radius: 0px">
                                                <i class="fas fa-print"></i>
                                                <span> Print </span>
                                            </button>
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
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        function printInvoice() {
            window.print();
        }
    </script>
</body>

</html>
