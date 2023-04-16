@extends('layouts.app')
@section('title')
{{$data['title']}}
@endsection
@section('custom_style')

@endsection
@section('main')

<div class="content-body">

    <button type="button" class="btn btn-info filter-btn btn-sm m-2" data-toggle="collapse" data-target="#filterBody"><i class="fa fa-filter"></i> Filters</button>
    <section class="content collapse show" id="filterBody">
        <div class="card">
            <div class="card-body">
                <form id="filterForm" action="#" method="POST">
                    @csrf()
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="name">Supplier</label>
                                    <select class="form-control supplier_id select2" id="supplier_id" name="supplier_id">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <label for="from">From Date <span class="requride_cls">*</span>
                                </label>
                                <input type="text" id="from" name="from" class="form-control" placeholder="Select Start Date" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label for="to">To Date <span class="requride_cls">*</span>
                                </label>
                                <input type="text" id="to" name="to" class="form-control" placeholder="Enter End Date" readonly>
                            </div>

                            <div class="col-lg-4">
                                <button type="submit" class="btn btn-success searchData btn-sm">Apply
                                </button>
                                <button class="btn btn-danger searchClear btn-sm" data-toggle="collapse" data-target="#filterBody">Cancel</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <!-- /.Filter -->
        </div>
    </section>

    <section id="configuration">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$data['module']}}</h4>
                        <div class="heading-elements">
                            <div class="btn-group float-md-right">
                                <a href="{{route('create_purchase_order')}}"><button class="btn shadow-primary waves-effect waves-light btn-square btn-primary" type="button">
                                        <i class="icon-plus mr-1"></i>Add {{$data['module']}}</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-dashboard m-1">
                            <div class="table-responsive">
                                <table style="width: 100%;" id="data_table" class="table-sm table-bordered  dataTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Order No.</th>
                                            <th>Supplier Name</th>
                                            <th>Amount</th>
                                            <th>Credit</th>
                                            <th>Debit</th>
                                            <th>Order Date</th>
                                            <th style="min-width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
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
        "scrollX": true,
        'autoWidth': false,
        processing: true,
        serverSide: true,
        pageLength: 50,
		    lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Download CSV',
                },
            ],
        ajax: {
            "url": "{{ route('get_purchase_order') }}",
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
                    return $("#supplier_id").val()
                },
            }
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
                data: 'supplier_id',
                name: 'supplier_id'
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
        ajax_select2_supplier();


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
            $('body').find('#supplier_id').val('').trigger('change');
            table.draw();
        });

        var order_payment_popup = "{{ route('purchase_order_payment_popup') }}";

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
                        url: "{{ route('delete_purchase_order')}}",
                        type: 'post',
                        data: {
                            "id": id
                        },
                        success: function(response) {
                            // window.location.reload();
                            table.draw();
                        }
                    });
                }
            });
    });
</script>
@endsection
