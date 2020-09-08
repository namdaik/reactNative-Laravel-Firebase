<!DOCTYPE html>
<html lang="en">

<head>
    <title>Waybill find &mdash; Quick order</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="{{ asset('assets/show-order.css') }}" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="board">
            <article class="card">
                <header class="card-header "> <img src="{{ asset('assets/images/logo.png') }}" class="mr-3"
                        width="50px">My Orders /
                    Tracking</header>
                <div class="card-body">
                    <h6>Order ID: {{ $order->id }}</h6>
                    <article class="card">
                        <div class="card-body row">
                            <div class="col"> <strong>Send by</strong> <br>{{ $order->user->name }}</div>
                            <div class="col"> <strong>Phone</strong> <br> <i class="fa fa-phone"></i>
                                {{ $order->user->phone }} </div>
                            <div class="col"> <strong>Address</strong> <br> {{ $order->user->address }} </div>
                            <div class="col"> <strong>Email</strong> <br> {{ $order->user->email }} </div>
                        </div>
                    </article>
                    <article class="card mt-2">
                        <div class="card-body row">
                            <div class="col"> <strong>From</strong>
                                <br>{{ $order->placeOfShipment->address }},
                                {{$order->placeOfShipment->ward->name}},
                                {{$order->placeOfShipment->ward->district->name}}<br>
                                {{$order->placeOfShipment->ward->district->province->name}}
                            </div>
                            <div class="col"> <strong>To</strong><br>
                                {{ $order->receivers->address }},
                                {{$order->receivers->ward->name}},
                                {{$order->receivers->ward->district->name}}<br>
                                {{$order->receivers->ward->district->province->name}} </div>
                            <div class="col"> <strong>Transaction point</strong> <br>
                                @if($order->transactionPoint)
                                {{ $order->transactionPoint->address }},
                                {{$order->transactionPoint->ward->name}},
                                {{$order->transactionPoint->ward->district->name}},
                                {{$order->transactionPoint->ward->district->province->name}}<br>
                                @endif
                            </div>
                            <div class="col"> <strong>Employee</strong> <br>
                                @if($order->employee)
                                {{ $order->employee->name }},<br>
                                {{ $order->employee->email }},<br>
                                @endif
                            </div>
                        </div>
                    </article>
                    <article class="card mt-2">
                        <div class="card-body row">
                            <div class="col"> <strong>Information</strong>
                                <br>Length:{{ $order->parcel_length }}<br>
                                Width:{{$order->parcel_width}}<br>
                                Height:{{$order->parcel_height}}<br>
                                Weight:{{$order->parcel_weight}}
                            </div>
                            <div class="col"> <strong>Description</strong><br>
                                {{ $order->parcel_description }}<br>
                            </div>
                            <div class="col"> <strong>Note</strong><br>
                                {{ $order->note }}<br>
                            </div>
                            <div class="col"> <strong>Status</strong><br>
                                @if($order->status == 0)
                                <p>Confirmation pending</p>
                                @elseif($order->status == 1)
                                <p>Confirmed</p>
                                @elseif($order->status == 2)
                                <p>Transporting</p>
                                @elseif($order->status == 3)
                                <p>On transaction point</p>
                                @elseif($order->status == 4)
                                <p>Delivering</p>
                                @elseif($order->status == 5)
                                <p>Done</p>
                                @elseif($order->status == -1)
                                <p>Canceled</p>
                                @endif
                            </div>
                        </div>
                    </article>
                    <div class="track">
                        @foreach ($order->shippingHistories as $shipping_history)
                        <div class="col">
                            <div><span class="icon"></div>
                            @if($shipping_history->order_status == 0)
                            <div class="text">Confirmation pending</div>
                            @elseif($shipping_history->order_status == 1)
                            <div class="text">Confirmed</div>
                            @elseif($shipping_history->order_status == 2)
                            <div class="text">Transporting</div>
                            @elseif($shipping_history->order_status == 3)
                            <div class="text">On transaction point</div>
                            @elseif($shipping_history->order_status == 4)
                            <div class="text">Delivering</div>
                            @elseif($shipping_history->order_status == 5)
                            <div class="text">Done</div>
                            @elseif($shipping_history->order_status == -1)
                            <div class="text">Canceled</div>
                            @endif
                            <div class="text">
                                {{ \Carbon\Carbon::parse($shipping_history->created_at)->isoFormat('MMM Do YY') }}</div>
                        </div>
                        @endforeach

                    </div>
                    <a href="{{url('/')}}" class="btn btn-warning mt-5" data-abc="true"> <i
                            class="fa fa-chevron-left"></i> Back to
                        orders</a>
                </div>
            </article>
        </div>
    </div>
</body>
