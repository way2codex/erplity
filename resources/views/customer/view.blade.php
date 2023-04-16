@extends('layouts.app')
@section('title')
{{ $data['title'] }}
@endsection
@section('custom_style')
@endsection
@section('main')
<div class="content-body">
    <section id="basic-form-layouts">
        <div class="row match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">View Details - {{ $customer['name'] }}</h4>
                        <input type="hidden" value="{{ $customer['id'] }}" id="customer_id" name="customer_id" />
                        <div class="heading-elements">
                            <div class="btn-group float-md-right">
                                <button class="receive_payment_btn btn shadow-primary waves-effect waves-light btn-square btn-primary" type="button">
                                    <i class="icon-plus mr-1"></i>Receive Full Payment
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="row">
                            <h5 class="ml-3">Orders History</h5>
                                <div class="table-responsive">
                                    <table style="width: 100%;" id="order_data_table" class="table table-bordered  order_dataTable table-sm">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Id</th>
                                                <th>Order No.</th>
                                                <th>Date</th>
                                                <th>Total Amount</th>
                                                <th>Credited Amount</th>
                                                <th>Debt Amount</th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Id</th>
                                                <th>Order No.</th>
                                                <th>Date</th>
                                                <th>Total Amount</th>
                                                <th>Credited Amount</th>
                                                <th>Debt Amount</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <h5 class="ml-3">Order Payments History </h5>
                                <div class="table-responsive">
                                    <table style="width: 100%;" id="payment_data_table" class="table table-bordered  payment_dataTable table-sm">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Order No.</th>
                                                <th>Amount</th>
                                                <th>Type</th>
                                                <th>Received Date</th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Order No.</th>
                                                <th>Amount</th>
                                                <th>Type</th>
                                                <th>Received Date</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal  fade" id="order_detail_modal" role="dialog" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content order_detail_modal_content"></div>
    </div>
</div>
<div class="modal  fade" id="customer_payment_modal" role="dialog" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content customer_payment_modal_content"></div>
    </div>
</div>

@endsection

@section('custom_script')

<script>
    // $(document).ready(function() {

    $('.select2').select2();

    var customer_id = $('#customer_id').val();

    var customer_payment_popup = "{{route('customer_payment_popup')}}";
    $(document).on('click', '.receive_payment_btn', function(e) {
        var id = customer_id;
        $.ajax({
            url: customer_payment_popup,
            type: "POST",
            data: {
                'id': id
            },
            success: function(response) {
                if (response.status == true) {
                    $('.customer_payment_modal_content').html(response.html);
                    $('#customer_payment_modal').modal('show');
                } else {
                    alert("Something Went Wrong ...", "Error");
                }
            }
        });
    });

    var order_detail_popup = "{{route('order_detail_popup')}}";
    $(document).on('click', '.order_info_btn', function(e) {

        var id = $(this).data('id');
        $.ajax({
            url: order_detail_popup,
            type: "POST",
            data: {
                'id': id
            },
            success: function(response) {
                if (response.status == true) {
                    $('.order_detail_modal_content').html(response.html);
                    $('#order_detail_modal').modal('show');
                } else {
                    alert("Something Went Wrong ...", "Error");
                }
            }
        });
    });


    var order_dataTable = $('.order_dataTable').DataTable({
        "scrollX": true,
        'autoWidth': false,
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("get_customer_order") }}',
            type: "get",
            data: function(d) {
                d.id = customer_id;
            },
        },
        "order": [
            [0, "asc"]
        ],
        "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                var amountTotal = [];
                var credit = [];
                var debit = [];
                for (let count = 0; count < data.length; count++) {
                    amountTotal.push(parseInt(data[count].final_total));
                    credit.push(parseInt(data[count].credit_amount));
                    debit.push(parseInt(data[count].debit_amount));
                }


                const Total = amountTotal.reduce((a, b) => a + b, 0);
                const Credit = credit.reduce((a, b) => a + b, 0);
                const Debit = debit.reduce((a, b) => a + b, 0);
                $(api.column(4).footer()).html(`<span class="text-info">Total: ${Total.toFixed(2)}</span>`);
                $(api.column(5).footer()).html(`<span class="text-info">Total: ${Credit.toFixed(2)}</span>`);
                $(api.column(6).footer()).html(`<span class="text-info">Total: ${Debit.toFixed(2)}</span>`);
            },
        columns: [{
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {
                data: 'order_no',
                name: 'order_no'
            },
            {
                data: 'order_date',
                name: 'order_date'
            },
            {
                data: 'final_total',
                name: 'final_total'
            },
            {
                data: 'credit_amount',
                name: 'credit_amount'
            },
            {
                data: 'debit_amount',
                name: 'debit_amount'
            }
        ]
    });
    var payment_dataTable = $('.payment_dataTable').DataTable({
        "scrollX": true,
        'autoWidth': false,
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("get_customer_payment") }}',
            type: "get",
            data: function(d) {
                d.id = customer_id;
            },
        },
        "order": [
            [0, "asc"]
        ],

        "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                var amountTotal = [];
                for (let count = 0; count < data.length; count++) {
                    amountTotal.push(parseInt(data[count].amount));
                }


                const Total = amountTotal.reduce((a, b) => a + b, 0);
                $(api.column(2).footer()).html(`<span class="text-info">Total: ${Total.toFixed(2)}</span>`);
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {
                data: 'order_id',
                name: 'order.order_no',
                orderable:false
            },
            {
                data: 'amount',
                name: 'amount'
            },
            {
                data: 'payment_type',
                name: 'payment_type'
            },
            {
                data: 'payment_datetime',
                name: 'payment_datetime'
            }
        ]
    });

    // });
</script>

@include($data['view'].'.script')
@endsection
