<div class="modal-header">
    <h5 class="modal-title"><i class="fa fa-star"></i> Order Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="card-content collapse show">
    <div class="card-body">
        <?php if ($debit_amount > 0) { ?>
            <form action="#" id='payment_add_form' name="customer_payment_add_form" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $customer['id'] }}" id="customer_id" name="customer_id" />
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Amount</label>
                                <input readonly type="number" value="<?php echo $debit_amount; ?>" class="form-control calculate_product_total discount" placeholder="Amount" id='amount' name="amount">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="datepicker"> Date</label>
                                <input type="text" value="<?php echo date('d-m-Y'); ?>" name="payment_datetime" id="payment_datetime" class="form-control datepicker" placeholder="Select Date" autocomplete="false" readonly />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="datepicker"> Type</label>
                                <select class="select2 form-control" id="payment_type" name="payment_type">
                                    <option value="0">Offline</option>
                                    <option value="1">Online</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn save_payment_btn shadow-primary waves-effect waves-light btn-square btn-primary">
                        <i class="fa fa-check-square-o"></i> Save
                    </button>
                    <a href="#">
                        <button type="button" data-dismiss="modal" class="btn shadow-danger waves-effect waves-light btn-square btn-danger mr-1">
                            <i class="fa fa-times"></i> Cancel
                        </button>
                    </a>
                </div>
            </form>
        <?php } else { ?>
            <center>No Payment Due</center>
        <?php } ?>
        <table style="margin-top:30px;" class="table-sm table table-bordered">
            <tr>
                <td>Order Id</td>
                <td>Total Amount</td>
                <td>Credited Amount</td>
                <td>Debt Amount</td>
            </tr>
            <?php foreach ($order as $key => $order_item) { ?>
                <tr>
                    <td>{{ $order_item['order_no'] }}</td>
                    <td>{{ $order_item['final_total'] }}</td>
                    <td>{{ $order_item['credit_amount'] }}</td>
                    <td>{{ $order_item['debit_amount'] }}</td>
                </tr>
            <?php } ?>
        </table>

    </div>
</div>

<script>
    var customer_payment_store = "{{route('customer_payment_store')}}";
    $(".save_payment_btn").off("click").on('click', function(e) {
        e.preventDefault();
        if ($("#payment_add_form").valid()) {
            $('.save_payment_btn').attr('disabled', true);
            var customer_id = $('#customer_id').val();
            var payment_type = $('#payment_type').val();
            var amount = $('#amount').val();
            var order_date = $('#order_date').val();
            $.ajax({
                url: customer_payment_store,
                type: "POST",
                data: {
                    'payment_type': payment_type,
                    'customer_id': customer_id,
                    'amount': amount,
                    'order_date': order_date
                },
                success: function(response) {
                    if (response.status == true) {
                        $('.customer_payment_modal_content').html('');
                        $('#customer_payment_modal').modal('hide');
                        success_noti('Payment Received Successfully.');
                        payment_dataTable.draw();
                        order_dataTable.draw();
                    } else {
                        $('.customer_payment_modal_content').html('');
                        $('#customer_payment_modal').modal('hide');
                        error_noti("Something Went Wrong ...");
                    }
                }
            });
        }
    });
</script>
<script>
    $('.select2').select2();

    $("#payment_add_form").validate({
        rules: {
            amount: {
                required: true
            },
            payment_datetime: {
                required: true
            },
        },
        messages: {
            amount: {
                required: "Please enter a amount",
            },
            payment_datetime: {
                required: "please enter date",
            },
        },
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent()); // radio/checkbox?
            } else if (element.hasClass('select2')) {
                error.insertAfter(element.next('span')); // select2
            } else {
                error.insertAfter(element); // default
            }
        }
    });
</script>

<script>
    $('.datepicker').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true
    });
</script>