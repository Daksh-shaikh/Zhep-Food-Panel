<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style type="text/css">
        @page {
            size: 3.5in auto;
            margin-top: -450px;
            margin-right: 0%;
            margin-left: 3%;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 100%;
            padding-top: 0;
        }

        .ordertable {
            border-collapse: collapse;
            width: 300px;
            text-align: left;
            padding-left: 1%;
        }

        h2 {
            text-align: center;
        }

        .headtable {
            width: 300px;
            padding: 0 0px;
        }

        .ordertable td {
            /* border-bottom: 1px solid #c3c9c6; */
            /* padding-top: 2px;
            padding-bottom: 8px; */
            background-color: #fff;
        }

        p {
            color: #000;
        }

        .row {
            max-width: 300px;
        }

        .div {
            max-width: 150px;
            display: inline;
        }

        .second {
            text-align: right;
            float: right;
            padding-top: 15px;
        }

        #contentss {
            margin-top: 0;
            width: 100%;
        }
    </style>
</head>

<body class="container" id="contentss" style="margin-top: -30px">
    <?php
    $serviceChargesValue = $order->restro->service_charges_value;
    $serviceChargesType = $order->restro->service_charges_type;
    ?>
    <div class="row">
        <div class="div">
            @if($logo)
            <img src="{{ asset('logo/' . $logo->logo) }}" alt="Restaurant Logo" style="height: 200px; width: 200px;">
    @endif
</div>
    </div>

    <h3 style="margin-top: -30px">{{$order->restro->restaurant}}</h3>

    {{-- <p style="font-size: 12px"><b>Hi {{$order->user->name}}</b></p> --}}
    <p style="margin-top: -10px">Thanks for choosing {{$order->restro->restaurant}}! </p>
    {{-- <br>Your order from {{$order->restro->restaurant}} has been delivered. <br>Looking forward to serving you again.</p> --}}

    <table class="headtable" style="margin-top: 0px;">
        <tr style="width: full;">
            <th style="width: 200px; text-align: left; font-size:12px">Order No:</th>
            <td style="width: 100px; text-align: left; font-size:12px">{{ $order->order_id2 }}</td>

            <th style="width: 100px; text-align: left; font-size:12px">Date:</th>
            <td style="width: 100px; text-align: left; font-size:12px">{{ $order->created_at->format('d/m/Y') }}</td>
        </tr>
        {{-- <tr>
            <th style="width: 100px; text-align: left;">Date:</th>
            <td style="width: 100px; text-align: left;">{{ $order->created_at->format('d/m/Y') }}</td>
        </tr> --}}
        {{-- <tr>
            <th style="width: 100px; text-align: left;">Shop From:</th>
            <td style="width: 100px; text-align: left;">{{$order->restro->restaurant}}</td>
        </tr> --}}
    </table>

    <table class="ordertable" style="margin-top: 10px; font-size: 12px;">
        <tr style="height: 30px; width: 600px; text-align: left;">
            <th style="width: 120px; text-align: left; height: 40px;">Item</th>
            <th style="width: 60px; text-align: left; height: 40px;">Quantity</th>
            <th style="width: 60px; text-align: left; height: 40px;">Price</th>
        </tr>

        @foreach ($cart as $item)
        <tr style="height: 20px;  text-align: left;">
            <td style="width: 120px; height: 25px;">{{$item->recipe_name}}</td>
            <td style="width: 60px;">{{$item->quantity}}</td>
            <td style="width: 60px;">{{$item->recipe_price}}</td>
        </tr>
        @endforeach
    </table>

    <table style="width: 300px; margin-top: 10px; ">
        {{-- <tr style="border-bottom: 1px solid #cfcbc8;">
            <td style="width: 120px; margin-left: -30px;">Discount: &#8377; 20</td>
        </tr> --}}
        {{-- <tr style="border-bottom: 1px solid #cfcbc8;">
            <td style="width: 120px; margin-left: -30px;">Delivery Charge: &#8377; 50</td>
        </tr> --}}
        <tr style="border-bottom: 1px solid #cfcbc8; text-align: left;">
            <td style="width: 120px; line-height: 2em; font-size:12px">
                <span style="float: left;"><b>Sub Total :</b></span>
                <span style="float: right;">&#8377; {{ $order->total }}</span>
            </td>
                    </tr>
        <tr style="border-bottom: 1px solid #cfcbc8; text-align: left; ">
            <td style="width: 120px; line-height: 2em; font-size:12px">
                <span style="float: left;"><b>Total GST : </b></span>
                <span style="float: right;">&#8377; {{ number_format($order->calculateTotalGst(), 2) }}</span>
            </td>

            {{-- <td style="width: 120px; margin-left: -30px; line-height: 2em"><b>Total GST : &#8377; {{ number_format($order->calculateTotalGst(), 2) }}</b></td> --}}
        </tr>

        <tr style="border-bottom: 1px solid #cfcbc8; text-align: left; ">
            <td style="width: 120px; line-height: 2em; font-size:12px">
                <span style="float: left;"><b>Service Charges : </b></span>
                @if($order->restro->service_charges_type=='Rupee')
                <span style="float: right;">&#8377; {{ $order->restro->service_charges_value}} </span>
                @elseif($order->restro->service_charges_type=='Percent')
                    <span style="float: right;"> {{ $order->restro->service_charges_value}} %</span>

                    @endif
            </td>
        </tr>

        <tr style="border-bottom: 1px solid #cfcbc8; text-align: left;">
            <td style="width: 120px; line-height: 2em; font-size:12px" >
                <span style="float: left;"><b>Discount : </b></span>
                <span style="float: right;">&#8377; {{ $order->discount }}</span>
            </td>
            {{-- <td style="width: 120px; margin-left: -30px; line-height: 2em"><b>Discount : &#8377; {{ $order->discount }}</b></td> --}}
        </tr>

        <tr style="border-bottom: 1px solid #cfcbc8; text-align: left;">
            <td style="width: 120px; line-height: 2em; font-size:12px">
                <span style="float: left;"><b>Total : </b></span>
                <span style="float: right;">&#8377; {{ $order->total + (number_format($order->calculateTotalGst(), 2)) - $order->discount + ($serviceChargesType == 'Rupee' ? $serviceChargesValue : ($order->total * $serviceChargesValue / 100)) }}</span>
            </td>
            {{-- <td style="width: 120px; margin-left: -30px; line-height: 2em"><b>Total Amount : &#8377; {{ $order->total + (number_format($order->calculateTotalGst(), 2)) - $order->discount }}</b></td> --}}
        </tr>
    </table>

    <div>
        <p style="font-size: 11px"> Managed By Zhep Food </p>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function() {
            var printContents = document.getElementById('contentss').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        });
    </script>
</body>

</html>
