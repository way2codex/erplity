<html>

<head>
    <style>
        table {
            border-collapse: collapse;
        }

        table,
        th {
            border: 1px solid black;
        }

        table,
        td {
            border: 1px solid black;
            font-size: 16px;
            padding: 2px 0px 2px 5px;
        }

        .table_border {
            border: 2px solid black;
            padding: 10px;
        }

        .remove_border {
            border-bottom: none !important;
            border-top: none !important;
        }

        .remove_table_border {
            border-bottom: none !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
        }

        div {
            text-align: center;
        }

        .page-break {
            page-break-before: always;
        }

        .text-right {
            text-align: right;
            padding-right: 10px;
        }

        .amount {
            text-align: right;
            padding-right: 60px;
        }

        .final_amount {
            text-align: right;
            padding-right: 56px;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }
    </style>
    <title>Order : {{ $data['order_no'] }}</title>
</head>

<body>
    <table border="1" width="100%">
        <tr>
            <td colspan="4" style="border-right:none !important; text-align: left;">
                <div style="text-align: left;">
                    <b>{{ Helper::setting()['company_name'] }}</b>
                    <br>
                    <?php
                    echo Helper::setting()['gst_no'] ? "GST No: " . Helper::setting()['gst_no'] . "<br>" : "";
                    echo Helper::setting()['pan_no'] ? "Pan No: " . Helper::setting()['pan_no'] . "<br>" : "";
                    echo Helper::setting()['mobile'] ? "Mobile: " . Helper::setting()['mobile'] . "<br>" : "";
                    echo Helper::setting()['email'] ? "Email: " . Helper::setting()['email'] . "<br>" : "";

                    ?>
                </div>
            </td>
            <td colspan="3" style="border-left:none !important; text-align: right;">
                <?php
                echo Helper::setting()['address'] ? "<b>Address</b><br> " . Helper::setting()['address'] . "<br>" : "";
                echo Helper::setting()['city'] ?  Helper::setting()['city'] . "<br>" : "";
                echo Helper::setting()['pincode'] ?  Helper::setting()['pincode'] . "<br>" : "";
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="border-right:none !important; text-align: left;">
                <div style="text-align: left;">
                    <b>Customer:</b>
                    <br>
                    <?php
                    echo $data['customer']['name'] ?  $data['customer']['name'] . "<br>" : "";
                    echo $data['customer']['mobile'] ? 'Mobile:' . $data['customer']['mobile'] . "<br>" : "";
                    echo $data['customer']['alt_mobile'] ? 'Mobile:' . $data['customer']['alt_mobile'] . "<br>" : "";
                    echo $data['customer']['email'] ? 'Email:' . $data['customer']['email'] . "<br>" : "";
                    echo $data['customer']['address'] ? 'Address:' . $data['customer']['address'] . "<br>" : "";
                    echo $data['customer']['city'] ?  $data['customer']['city'] . "<br>" : "";
                    echo $data['customer']['pincode'] ?  $data['customer']['pincode'] . "<br>" : "";
                    echo $data['customer']['gst_no'] ? 'GST No:' . $data['customer']['gst_no'] . "<br>" : "";

                    ?>
                </div>
            </td>
            <td colspan="3" style="border-left:none !important; text-align: right;">
                <h4 style="margin-right: 4px;">Order No: {{ $data['order_no'] }}</h4>

                <span>
                    Order Date : {{ date('d-m-Y', strtotime($data['order_date'])) }}
                </span>
                <br>
                <span>
                @if($data['due_date'])
                     Due Date : {{ date('d-m-Y', strtotime($data['due_date'])) }}
                @endif
                </span>
            </td>
        </tr>
        <tbody>
            <tr>
                <th style="width:5%;">Sr No.</th>
                <th style="width:40%;">Product</th>
                <th style="width:5%;">Quantity</th>
                <th style="width:10%;">Rate</th>
                <th style="width:10%;">Gst %</th>
                <th style="width:10%;">Gst</th>
                <th style="width:10%;">Amount</th>
            </tr>

            @foreach ($data->order_product as $key=> $item)
            <tr>
                <td class="center">{{$loop->iteration}}</td>
                <td class="left">{{$item->product['name']}}</td>
                <td class="right">{{$item->quantity}}</td>
                <td class="right">{{number_format($item->rate,2,'.',',')}}</td>
                <td class="right">{{$item->gst_percentage ? $item->gst_percentage : 0.00 }}</td>
                <td class="right">{{number_format($item->gst_amount,2,'.',',')}}</td>
                <td class="right">{{number_format($item->total,2,'.',',')}}</td>
            </tr>
            @endforeach
        </tbody>
        <tr>
            <th class="right" colspan="6">Total</th>
            <th class="right">{{ number_format($data->total,2,'.',',')}}</th>
        </tr>
        <tr>
            <th class="right" colspan="6">Discount</th>
            <th class="right">{{ number_format($data->discount,2,'.',',')}}</th>
        </tr>
        <tr>
            <th class="right" colspan="6">Final Amount</th>
            <th class="right">{{ number_format($data->final_total,2,'.',',')}}</th>
        </tr>

        <tbody>
            <tr>
                <td style="border-right:none !important;border-bottom:none !important;">
                </td>
                <td colspan="6" style="border-left:none !important;border-bottom:none !important;">
                    <b style="float:right; margin-top:20px;margin-right:4px;">For. {{ Helper::setting()['company_name'] }} </b><br />
                </td>
            </tr>
            <tr>
                <td style="vertical-align:bottom;border-top:none !important;border-right:none !important;border-left:none !important;border-left:none !important;"></td>
                <td colspan="6" style="vertical-align:bottom;border-top:none !important;border-left:none !important;text-align:right;padding-top:50px;">
                    <b style="margin:4px;">(Authorized Signature)</b>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
