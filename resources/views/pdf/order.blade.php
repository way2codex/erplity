<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:300,400,600,700');

/* General */
html {
	font-family: 'Poppins', sans-serif;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust: 100%;
	-ms-overflow-style: scrollbar;
	-webkit-tap-highlight-color: transparent
}
@-ms-viewport {
	width: device-width
}
body {
	/* background:#f1f1f1; */
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    color: #636363;
    letter-spacing: 1px;
}


        .section-2 {
            margin-top: -7px;
        }

        .section-1 {
            margin-left: 1px;
        }


        table {
            border: 1px solid black;
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            text-transform: capitalize;
            padding: 4px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .border {
            border: 1px inset black;
        }

        .flexbox {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-direction: row;
        }

        .font-size {
            font-size: small;
        }
    </style>
</head>

<body>

    <center>
        <table align="center">
            <caption><h4> {{auth()->user()->name }} - {{Helper::setting()['mobile']}}</h4></caption>
            <thead>
                <tr class="border">
                    <td>
                            @if(Helper::setting()['logo'] != '')
                            <img src="{{ Helper::setting()['logo'] }}" style="width: 80px;height: 80px;" alt="Logo">
                            @endif
                    </td>
                    <td colspan="5" class="center">
                        <h3 style="text-transform: uppercase;">{{ Helper::setting()['company_name'] }}</h3>
                        <span style="text-transform: capitalize;">{{ Helper::setting()['address'] }}<br />
                        <strong>GST NO:- {{ Helper::setting()['gst_no'] ?? Helper::setting()['gst_no']}}</strong>
                    </td>

                    <td></td>
                </tr>
            </thead>
            <thead>
                <tr class="border font-size">
                    <td class="left" colspan="2">
                        <span><strong> Order No :-</strong> {{ $data['order_no'] }}</span>
                    </td>
                    <td colspan="3" class="center">
                        <span><strong> Order Date :-</strong> {{ date('d-m-Y',strtotime($data['order_date'])) }}</span>
                    </td>
                    <td class="right" colspan="2">
                        <span><strong> Due Date :-</strong> {{ date('d-m-Y',strtotime($data['due_date'])) }}</span>
                    </td>
                </tr>
            </thead>

            <thead>
                <tr>
                    <th class="left" colspan="3"> Customer Name :</th>
                    <td colspan="4">{{ $data->customer->name}}</td>
                </tr>
                <tr>
                    <th class="left" colspan="3"> Mobile :</th>
                    <td colspan="4"> {{ $data->customer->mobile}} </td>
                </tr>

                <tr>
                    <th class="left" colspan="3"> City :</th>
                    <td colspan="4"> {{ $data->customer->city}} - {{ $data->customer->pincode}}</td>
                </tr>

                @if($data->customer->address != '')
                <tr>
                    <th class="left" colspan="3"> Full Address :</th>
                    <td colspan="4"> {{ $data->customer->address }} </td>
                </tr>
                @endif
            </thead>
            <thead>
                <tr class="border">
                    <th class="border left" style="min-width: 5px !important;">Sr No</th>
                    <th class="border left" style="min-width: 120px !important;">Product</th>
                    <th class="border left" style="min-width: 90px !important;">Rate</th>
                    <th class="border left" style="min-width: 50px !important;">Quantity</th>
                    <th class="border left" style="min-width: 50px !important;">Gst %</th>
                    <th class="border left" style="min-width: auto !important;">Gst</th>
                    <th class="border left" style="min-width: 100px !important;">Amount</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data->order_product as $key=> $item)
                <tr>
                    <td class="border left">{{$loop->iteration}}.</td>
                    <td class="border left">{{$item->product['name']}}</td>
                    <td class="border left">{{number_format($item->rate,2,'.',',')}}/-</td>
                    <td class="border left">{{$item->quantity}}</td>
                    <td class="border left">{{$item->gst_percentage ? $item->gst_percentage : 0.00 }}%</td>
                    <td class="border left">{{number_format($item->gst_amount,2,'.',',')}}/-</td>
                    <td class="border left">{{number_format($item->total,2,'.',',')}}/-</td>
                </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr class="border">
                    <th class="left" colspan="6">Total</th>
                    <th class="right">{{ number_format($data->total,2,'.',',')}}</th>
                </tr>
                <tr class="border">
                    <th class="left" colspan="6">Discount</th>
                    <th class="right">{{ number_format($data->discount,2,'.',',')}}</th>
                </tr>
                <tr class="border">
                    <th class="left" colspan="6">Final Amount</th>
                    <th class="right">{{ number_format($data->final_total,2,'.',',')}}</th>
                </tr>

                <tr>
                    <td colspan="6">
                        <strong>Note: </strong>
                        <div style="padding-top:200px;">

                        </div>
                    </td>
                    <td class="left">
                        <div style="padding-top:200px;">
                            <span style="white-space: nowrap">(Authorised Singnatory)</span>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </center>
</body>

</html>
