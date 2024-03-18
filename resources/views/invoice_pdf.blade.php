<!-- invoice_pdf.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
</head>

<body>
    <div class="container">
        <div class="row" style="display: flex; justify-content: center; align-items: center">
            <div class="col-md-8 col-sm-12 card mt-5" style="border-radius: 0px;">
                <div class="card-header">
                    <div class="logo"
                        style="width: 20%; display: flex; justify-content: space-around; align-items: flex-end">
                        <img style="width: 100%; height: auto"
                            src="https://gymove.northerncommodities.com/assets/gymsol-logo.png" alt="">
                    </div>
                    <h4 class="text text-black-50 text-bold"
                        style="display: flex; justify-content: flex-end; align-items: flex-start; flex-direction: column; font-weight: bold;">
                        <div class="GYM"> <span class="text text-info">{{ $clubSetting->gym_name }}</span> </div>
                        <div class="invoice text-info"> Invoice <span class="text text-capitalize text-black"
                                style="font-weight: 200; font-size: 16px; margin-top:5px;">#{{ $data->invoice_url }}</span>
                        </div>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="mt-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">

                            <div class="card" style="box-shadow: none;">
                                <div class="card-header">
                                    <strong>From</strong>
                                </div>
                                <div class="card-body pb-0"
                                    style="box-shadow: none; border: 0.5px solid rgba(0,0,0,0.1)">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>GYM</strong>
                                            <span class="mb-0">{{ $clubSetting->gym_name }}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Owner</strong>
                                            <span class="mb-0">{{ $clubSetting->owner_name }}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Contact No </strong>
                                            <span class="mb-0">{{ $clubSetting->contact_1 }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">

                            <div class="card" style="box-shadow: none;">

                                <div class="card-header">
                                    <strong>To</strong>
                                </div>

                                <div class="card-body pb-0"
                                    style="box-shadow: none; border: 0.5px solid rgba(0,0,0,0.1)">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Name</strong>
                                            <span class="mb-0">{{ $data->name }}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Phone</strong>
                                            <span class="mb-0">{{ $data->phone }}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Issued On</strong>
                                            <span class="mb-0">{{ $data->date }}</span>
                                        </li>
                                        <li class="list-group-item d-flex px-0 justify-content-between">
                                            <strong>Expire On</strong>
                                            <span class="mb-0">{{ $data->expiry }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                </div>
            </div>
        </div>

    </div>

</body>

</html>
