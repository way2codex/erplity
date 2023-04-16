@extends('layouts.app')
@section('title')
{{ $data['title'] }}
@endsection
@section('main')
@include('infobox')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-info nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabs-1"><i class="fa fa-credit-card"></i> <span class="hidden-xs">Today's Due Payments</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-2"><i class="fa fa-windows"></i> <span class="hidden-xs">Today's Orders</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-3"><i class="fa fa-money"></i> <span class="hidden-xs">Today's Completed Payments</span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="tabs-1" class="container pad_0 tab-pane active">
                        @include('due_date_order')
                    </div>
                    <div id="tabs-2" class="container pad_0 tab-pane fade">
                        @include('today_order')
                    </div>
                    <div id="tabs-3" class="container pad_0 tab-pane fade">
                        @include('today_payment')
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <!-- <div class="col-lg-12">
        @include('due_date_order')
    </div>

    <div class="col-lg-12">
        @include('today_order')
    </div>

    <div class="col-lg-12">
        @include('today_payment')
    </div> -->

    <div class="col-lg-12">
        @include('order_chart')
    </div>
</div>
<!--End Row-->
@endsection
@section('custom_script')
<script>
    success_noti('Welcome {{ auth()->user()->name }} To Dashboard');
    $(document).ready(function() {
        // Today Due Data
        $('#due_datatable').DataTable({
            bPaginate: false,
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route('get_order') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    due_date: function() {
                        return "{{ date('d-m-Y') }}";
                    },
                }
            },
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                var amountTotal = [];
                for (let count = 0; count < data.length; count++) {
                    amountTotal.push(parseInt(data[count].final_total));
                }
                const Total = amountTotal.reduce((a, b) => a + b, 0);
                $(api.column(2).footer()).html(`Total Amount`);
                $(api.column(3).footer()).html(
                    `<span class="text-info">${Total.toFixed(2)}</span>`);
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'order_no',
                    name: 'order_no',
                },
                {
                    data: 'customer_id',
                    name: 'customer.name',
                    orderable: false,
                },
                {
                    data: 'final_total',
                    name: 'final_total',
                    "render": function(data, type, row, meta) {
                        return data.toFixed(2);
                    },
                },
                {
                    data: 'order_date',
                    name: 'order_date',
                },
            ],
        });


        // Today's Orders
        $('#today_datatable').DataTable({
            bPaginate: false,
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route('get_order') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    today: function() {
                        return "{{ date('d-m-Y') }}";
                    },
                }
            },
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                var amountTotal = [];
                for (let count = 0; count < data.length; count++) {
                    amountTotal.push(parseInt(data[count].final_total));
                }
                const Total = amountTotal.reduce((a, b) => a + b, 0);
                $(api.column(2).footer()).html(`Total Amount`);
                $(api.column(3).footer()).html(
                    `<span class="text-info">${Total.toFixed(2)}</span>`);
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'order_no',
                    name: 'order_no'
                },
                {
                    data: 'customer_id',
                    name: 'customer.name',
                    orderable: false,
                },
                {
                    data: 'final_total',
                    name: 'final_total',
                    "render": function(data) {
                        return data.toFixed(2);
                    },
                },
                {
                    data: 'payment_status',
                    name: 'payment_status',
                    "render": function(data) {
                        return `<span class='badge badge-warning'>${data.toUpperCase()}</span>`;
                    }
                },
            ],
        });


        $('#payment_datatable').DataTable({
            bPaginate: false,
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route('get_order_payments') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    today: function() {
                        return "{{ date('Y-m-d') }}"
                    },
                }
            },
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                var amountTotal = [];
                for (let count = 0; count < data.length; count++) {
                    amountTotal.push(parseInt(data[count].amount));
                }

                const sum = amountTotal.reduce((a, b) => a + b, 0);
                $(api.column(2).footer()).html(`Total Amount`);
                $(api.column(3).footer()).html(`<span class="text-info"> ${sum.toFixed(2)}</span>`);
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'order.order_no',
                    name: 'order.order_no',
                    orderable: false
                },
                {
                    data: 'customer_id',
                    name: 'customer_id'
                },
                {
                    data: 'amount',
                    name: 'amount',
                    "render": function(data, type, row, meta) {
                        return data.toFixed(2);
                    },
                },
                {
                    data: 'payment_time',
                    name: 'payment_time',
                },
            ]
        });

        var days = {!!json_encode($dashboard['currentMontsDays'])!!}
        var amounts = {!!json_encode($dashboard['orderAmount']) !!}


        if ($('#barChart').length) {
            var ctx = document.getElementById("barChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: days,
                    datasets: [{
                            label: 'Sales Of Current Month',
                            data: amounts,
                            backgroundColor: [
                                "#ff9700",
                                "#fd3550",
                                "#008cff",
                                "#fd3550",
                                "#15ca20",
                                "#0dceec",
                                "#223035",
                                "#fd3550",
                                "#75808a",
                                "#0dceec",
                                "#15ca20",
                                "#fd3550",
                                "#223035",
                                "#ff9700",
                                "#ff9700",
                                "#fd3550",
                                "#008cff",
                                "#fd3550",
                                "#15ca20",
                                "#0dceec",
                                "#223035",
                                "#fd3550",
                                "#75808a",
                                "#0dceec",
                                "#ee0979",
                                "#fd3550",
                                "#223035",
                                "#ee0979",
                                "#fd3550",
                                "#223035",
                                "#ee0979",
                                "#ffc107",
                                "#223035",
                                "#ee0979",
                            ],

                        },

                    ]
                }
            });
        }
    });
</script>
@endsection