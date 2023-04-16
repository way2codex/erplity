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
        .td_border {
            border-right:0px solid green;
        }
    </style>
    <title>Expense Report : {{ date('M-Y') }}</title>
</head>

<body>
    <table border="1" width="100%">
        <caption>Expense Report - {{ Helper::setting()->company_name }} </caption>
        <thead>
            <tr class="td_border">
                <td colspan="5"><b>From Date:</b> {{ date('d-m-Y',strtotime($from)) }}</td>
            </tr>

            <tr class="td_border">
                <td colspan="5"><b>To Date:</b> {{ date('d-m-Y',strtotime($to)) }}</td>
            </tr>

            <tr>
                <th>Sr No</th>
                <th>Name / Title</th>
                <th>Credited</th>
                <th>Debited</th>
                <th>Date</th>
            </tr>
        </thead>
@php
$creditTotal = 0;
$debitTotal = 0;
@endphp
        <tbody>
            @foreach ($expenses as $key => $val)
                <tr>
                    <td>{{ $key + 1}}.</td>
                    <td>{{ $val->name }}</td>
                    <td>
                        @if($val->transaction_type == 1) {{number_format($val->amount,2)}} @php $creditTotal+=$val->amount; @endphp @else - @endif
                    </td>
                    <td>
                        @if($val->transaction_type == 0) {{number_format($val->amount,2)}} @php $debitTotal+=$val->amount; @endphp @else - @endif
                    </td>
                    <td>{{ date('d-m-Y',strtotime($val->transaction_date)) }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td><b>Total: {{ number_format($creditTotal,2)}}</b></td>
                <td><b>Total: {{ number_format($debitTotal,2)}}</b></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="5" style="border-left:none !important;border-bottom:none !important;">Note: <br><br></td>
            </tr>
        </tfoot>


    </table>
</body>

</html>
