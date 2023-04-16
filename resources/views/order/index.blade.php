    @extends('layouts.app')
    @section('title')
        {{ $data['title'] }}
    @endsection
    @section('custom_style')
        <style>
            body {
                overflow-x: hidden;
            }
        </style>
    @endsection
    @section('main')
        <div class="content-body">
            <button type="button" class="btn btn-info filter-btn btn-sm m-2" data-toggle="collapse"
                data-target="#filterBody"><i class="fa fa-filter"></i> Filters</button>
            <section class="content collapse show" id="filterBody">
                <div class="card">
                    <div class="card-body">
                        <form id="filterForm" action="#" method="POST">
                            @csrf()
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="name">Customer</label>
                                            <select class="form-control customer_id" id="customer_id" name="customer_id">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="from">From Date
                                        </label>
                                        <input type="text" id="from" name="from" class="form-control"
                                            placeholder="Select From Date" readonly>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="to">To Date
                                        </label>
                                        <input type="text" id="to" name="to" class="form-control"
                                            placeholder="Select To Date" readonly>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="to">Order Due Date
                                        </label>
                                        <input type="text" id="due_date" name="due_date" class="form-control datepicker"
                                            placeholder="Select Due Date" readonly>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="name">Payment Status</label>
                                            <select class="form-control payment_status" id="payment_status"
                                                name="payment_status">
                                                <option value="">Select Status</option>
                                                <option value="paid">Paid</option>
                                                <option value="unpaid">Unpaid</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mt-2">
                                        <button type="submit" class="btn btn-success searchData btn-sm">Apply
                                        </button>
                                        <button class="btn btn-danger searchClear btn-sm" data-toggle="collapse"
                                            data-target="#filterBody">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </section>
            <section id="configuration">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $data['module'] }}</h4>
                        <div class="heading-elements">
                            <div class="btn-group float-md-right">
                                <a href="{{ route('create_order') }}"><button
                                        class="btn shadow-primary waves-effect waves-light btn-square btn-primary"
                                        type="button">
                                        <i class="icon-plus mr-1"></i>Add {{ $data['module'] }}</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-dashboard m-1">
                            <div class="table-responsive">
                                <table id="data_table" class="table-bordered dataTable table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Order No.</th>
                                            <th>Customer</th>
                                            <!-- <th>Products</th> -->
                                            <th>Amount</th>
                                            <th>Credit</th>
                                            <th>Debit</th>
                                            <th>Order Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Order No.</th>
                                            <th>Customer</th>
                                            <!-- <th>Products</th> -->
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Order Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="modal fade" id="index_modal" role="dialog" data-backdrop="static" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="form">
                <div class="modal-content index_modal_content"></div>
            </div>
        </div>
    @endsection
    @section('custom_script')
        <script>
            var table = $('.dataTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel'
                ],
                "scrollX": true,
                'autoWidth': false,
                processing: true,
                serverSide: true,
                pageLength: 50,
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'csv',
                    text: 'Download CSV',
                }, ],
                ajax: {
                    "url": "{{ route('get_order') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        from: function() {
                            return $("#from").val();
                        },
                        to: function() {
                            return $("#to").val();
                        },
                        customer_id: function() {
                            return $("#customer_id").val()
                        },
                        payment_status: function() {
                            return $("#payment_status").val()
                        },
                        due_date: function() {
                            return $("#due_date").val()
                        },
                    }
                },
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
                    $(api.column(3).footer()).html(`<span class="text-info">Total: ${Total.toFixed(2)}</span>`);
                    $(api.column(4).footer()).html(`<span class="text-info">Total: ${Credit.toFixed(2)}</span>`);
                    $(api.column(5).footer()).html(`<span class="text-info">Total: ${Debit.toFixed(2)}</span>`);
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
                    // {
                    //     data: 'total_product',
                    //     name: 'total_product',
                    //     orderable: false,
                    // },
                    {
                        data: 'final_total',
                        name: 'final_total',
                        "render": function(data, type, row, meta) {
                            return data.toFixed(2);
                        },
                    },
                    {
                        data: 'credit_amount',
                        name: 'credit_amount',
                        "render": function(data, type, row, meta) {
                            return data.toFixed(2);
                        },
                    },
                    {
                        data: 'debit_amount',
                        name: 'debit_amount',
                        "render": function(data, type, row, meta) {
                            return data.toFixed(2);
                        },
                    },
                    {
                        data: 'order_date',
                        name: 'order_date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            $(document).ready(function() {
                ajax_select2_customer();

                $('.payment_status').select2({
                    placeholder: "Select Status",
                    allowClear: true
                })


                $('#from').datepicker({
                        format: 'dd-mm-yyyy',
                        todayHighlight: true,
                        autoclose: true,
                    })
                    .on('changeDate', function(selected) {
                        var minDate = new Date(selected.date.valueOf());
                        $('#to').datepicker('setStartDate', minDate);
                    });

                $('#to').datepicker({
                        format: 'dd-mm-yyyy',
                        todayHighlight: true,
                        autoclose: true,
                    })
                    .on('changeDate', function(selected) {
                        var maxDate = new Date(selected.date.valueOf());
                        $('#from').datepicker('setEndDate', maxDate);
                    });

                $('.searchData').on('click', function(e) {
                    e.preventDefault();
                    table.draw();
                });

                $('.searchClear').on('click', function(e) {
                    e.preventDefault();
                    $('body').find('#from').val('');
                    $('body').find('#to').val('');
                    $('body').find('#customer_id').val('').trigger('change');
                    $('body').find('#due_date').val('');
                    $('body').find('#payment_status').val('').trigger('change');
                    table.draw();
                });
            })
        </script>
        <script>
            $(document).ready(function() {
                var order_payment_popup = "{{ route('order_payment_popup') }}";

                $(document).on('click', '.add_payment_btn', function(e) {
                    $('.index_modal_content').html('');

                    var id = $(this).data('id');
                    $.ajax({
                        url: order_payment_popup,
                        type: "POST",
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            if (response.status == true) {
                                $('.index_modal_content').html(response.html);
                                $('#index_modal').modal('show')
                            } else {
                                alert("Something Went Wrong ...", "Error");
                            }
                        }
                    });
                });
            });
            $(document).on('click', '.delete_record_warning', function(e) {
                warning_noti("This order can'be delete ,because payment received");
            });
            $(document).on('click', '.delete_record', function(e) {

                var id = $(this).data("id");
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "{{ route('delete_order') }}",
                                type: 'post',
                                data: {
                                    "id": id
                                },
                                success: function(response) {
                                    table.draw();
                                }
                            });
                        }
                    });
            });
        </script>
        @include('order.script')
    @endsection
