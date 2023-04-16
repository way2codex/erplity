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
    </style>
    <title>Pay Slip : {{ date('M-Y') }}</title>
</head>

<body>
    <table border="1" width="100%">
        <tr>
            <td colspan="4" style="border-right:none !important;">
                <div><b>aaa</b></div>
            </td>
        </tr>
        <tr>
            <td><b>Month :</td>
            <td colspan="3">aa</td>
        </tr>
        <tr>
            <td><b>Owner Name :</td>
            <td>{{ $vehiclePaySlip->vehicle->carowner->name }}</td>
            <td><b>Owner Mobile No :</td>
            <td>{{ $vehiclePaySlip->vehicle->carowner->mobile }}</td>
        </tr>
        <tr>
            <td><b>Owner Pan No :</td>
            <td colspan="3">-</td>
        </tr>
        <tr>
            <td><b>Vehicle No :</td>
            <td colspan="2">{{ $vehiclePaySlip->vehicle->vehicle_no }}</td>
            <td><b>Make :</b> {{ $vehiclePaySlip->vehicle->vehiclemodel->vehiclemake->name }}</td>
        </tr>
        <tr>
            <td><b>Site Name :</td>
            <td colspan="2">{{ $vehiclePaySlip->site->site_name }} </td>
            <td><b>Mobile No :</b> {{ $vehiclePaySlip->site->mobile_no }}</td>
        </tr>
        <tr>
            <th style="width:20%;">Sr No.</th>
            <th style="width:30%;">Date</th>
            <th style="width:25%;">Hours</th>
            <th style="width:25%;">Amount</th>
        </tr>
        <tbody>
            @foreach ($vehiclePaySlip->hourspayment as $item)
            <tr>
                <td class="center">{{$loop->iteration}}</td>
                <td>{{$item->date}}</td>
                <td class="center">{{ $item->hours }}</td>
                <td class="amount">{{ number_format($item->amount,2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tr>
            <th style="width:20%;">Sr No.</th>
            <th style="width:30%;">Particular</th>
            <th style="width:25%;">Rate</th>
            <th style="width:25%;">Amount</th>
        </tr>
        <tbody>
            <tr>
                <td class="center">1</td>
                <td>Total KM ({{ $vehiclePaySlip->total_km }})</td>
                <td class="center">
                    {{ $vehiclePaySlip->total_rate }}
                </td>
                <td class="amount">

                </td>
            </tr>
            {{--<tr>
                    <td class="center">2</td>
                    <td>Package Amount</td>
                    <td class="center">
                    {{ $vehiclePaySlip->package_amount }}
            </td>
            <td class="amount">

            </td>
            </tr> --}}
            <tr>
                <td class="center">3</td>
                <td>Package Days</td>
                <td class="center">
                    {{ $vehiclePaySlip->package_days }}
                </td>
                <td class="amount">

                </td>
            </tr>
            <tr>
                <td class="center">4</td>
                <td>Present Day</td>
                <td class="center">
                    {{ $vehiclePaySlip->present_days }}
                </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->package_pay, 2) }}
                </td>
            </tr>
            <tr>
                <td class="center">5</td>
                <td>Use KM</td>
                <td class="center">
                    {{ $vehiclePaySlip->use_km }}
                </td>
                <td class="amount">
                </td>
            </tr>

            <tr>
                <td class="center">6</td>
                <td>Extra KM (Rate : {{ $vehiclePaySlip->extra_rate_per_km }})</td>
                <td class="center">
                    {{ $vehiclePaySlip->extra_km }}
                </td>
                <td class="amount">{{ number_format($vehiclePaySlip->extra_km_amount, 2) }}</td>
            </tr>
            <tr>
                <td class="center">7</td>
                <td>Extra Hours (Rate : {{ $vehiclePaySlip->extra_rate_per_hour }})</td>
                <td class="center">
                    {{ $vehiclePaySlip->extra_hours }}
                </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->extra_hours_amount, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">Additional Remark :
                    {{ $vehiclePaySlip->additional_remark }}
                </td>
                <td class="text-right">Additional Amount : </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->additional_payment, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><strong>Total Amount : </strong></td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->total_amount, 2) }}
                </td>
            </tr>

            <tr>
                <td colspan="3" class="text-right">Processing Fees : </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->processing_fees, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">Installment : </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->installment, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">PCC : </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->pcc, 2) }}
                </td>
            </tr>
            <!--
                <tr>
                    <td colspan="3" class="text-right">Fuel Advance : </td>
                    <td class="amount">
                    {{ number_format($vehiclePaySlip->fuel_advance, 2) }}
                    </td>
                </tr>
                -->

            <!--
                <tr>
                    <td colspan="3" class="text-right">Cleanliness : </td>
                    <td class="amount">
                    {{ number_format($vehiclePaySlip->cleanliness, 2) }}
                    </td>
                </tr>

                <tr>
                    <td colspan="3" class="text-right">No Smoking : </td>
                    <td class="amount">
                    {{ number_format($vehiclePaySlip->no_smoking, 2) }}
                    </td>
                </tr>

                <tr>
                    <td colspan="3" class="text-right">Absent Penalty : </td>
                    <td class="amount">
                    {{ number_format($vehiclePaySlip->absent_penalty, 2) }}
                    </td>
                </tr>
                -->
            <tr>
                <td colspan="3" class="text-right">Penalty : </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->penalty, 2) }}
                </td>
            </tr>

            <tr>
                <td colspan="3" class="text-right">Other Deduction : </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->other_deduction, 2) }}
                </td>
            </tr>

            <tr>
                <td colspan="3" class="text-right">{{ $siteSetting->service_charge }} % Service Charges : </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->service_charges, 2) }}
                </td>
            </tr>

            <tr>
                <td colspan="3" class="text-right"><strong>Basic Amount : </strong></td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->basic_amount, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-right"><label id="amount_err"></label></td>
                <td colspan="1" class="text-right">Toll : </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->toll, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><strong>Net Basic Amount : </strong></td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->net_basic_amount, 2) }}
                </td>
            </tr>

            @if($vehiclePaySlip->csp_id != 2)
            <tr>
                <td colspan="3" class="text-right"> {{ $retentionPercentage }} % Retention Amt.will be Refund In Next Month : </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->retention, 2) }}
                </td>
            </tr>
            @endif

            <tr>
                <td colspan="3" class="text-right">Retention Refund Amount : </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->refund_retention, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><strong>Gross Amount : </strong></td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->gross_amount, 2) }}
                </td>
            </tr>
            <!--
                <tr>
                    <td colspan="3" class="text-right">Medical Expence : </td>
                    <td class="amount">
                    {{ number_format($vehiclePaySlip->medical_expence, 2) }}
                    </td>
                </tr>
                -->
            <tr>
                <td colspan="3" class="text-right">Advance : </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->advance, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">{{ $TDS }} % TDS : </td>
                <td class="amount">
                    {{ number_format($vehiclePaySlip->tds, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-right" style="text-align:right;">Previous Month Payment : </td>
                <td class="final_amount">
                    {{ number_format($vehiclePaySlip->previous_payment, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-right" style="text-align:right;"><strong>Final Amount Payable : </strong></td>
                <td class="final_amount">
                    <b>{{ number_format($vehiclePaySlip->net_payment, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="4"><b>Total Invoice Amount in Words :</b>@if($vehiclePaySlip->net_payment > 0) {{ Helper::convertNumberToWord($vehiclePaySlip->net_payment) }} @else {{ $vehiclePaySlip->net_payment }} @endif</td>
            </tr>
            <tr>
                <td colspan="4" style="padding:10px"> </td>
            </tr>
            <tr>
                <td class="text-right">Ch No : </td>
                <td colspan="3">

                </td>
            </tr>
            <tr>
                <td class="text-right">Date : </td>
                <td colspan="3">

                </td>
            </tr>
            <tr>
                <td class="text-right">A/C No : </td>
                <td></td>
                <td class="text-right">Bank Name : </td>
                <td></td>
            </tr>
            <tr>
                <td class="text-right">IFSC Code : </td>
                <td></td>
                <td class="text-right">Branch Name : </td>
                <td></td>
            </tr>
            <tr>
                <td style="border-right:none !important;border-bottom:none !important;">
                </td>
                <td colspan="3" style="border-left:none !important;border-bottom:none !important;">
                    <b style="float:right;">For. Sarathi Digital </b><br />
                </td>
            </tr>
            <tr>
                <td style="vertical-align:bottom;border-top:none !important;border-right:none !important;border-left:none !important;border-left:none !important;"></td>
                <td colspan="3" style="vertical-align:bottom;border-top:none !important;border-left:none !important;text-align:right;padding-top:50px;"><b>(Authorized Signature)</b></td>
            </tr>
        </tbody>
    </table>
</body>

</html>