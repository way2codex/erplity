<div class="modal-header">
    <h5 class="modal-title"><i class="fa fa-star"></i> Payments</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="card-content collapse show">
    <div class="card-body">

        <?php if ($order['debit_amount'] > 0) { ?>
            <form action="#" id='payment_add_form' name="payment_add_form" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $order['id'] }}" id="order_id" name="order_id" />
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Amount</label>
                                <input max="<?php echo $order['debit_amount']; ?>" type="number" class="form-control calculate_product_total discount" placeholder="Amount" id='amount' name="amount">
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
                                <label for="datepicker">Payment Method</label>
                                <select class="select2 form-control" id="payment_type" name="payment_type">
                                    <option value="0">Offline</option>
                                    <option value="1">Online</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn save_payment_btn shadow-primary waves-effect waves-light btn-square btn-primary">
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
                <td>Final Total</td>
                <td><span class="popup_final_total"><?php echo $order['final_total']; ?></span></td>
            </tr>
            <tr>
                <td>Credited Amount</td>
                <td><span class="popup_final_total"><?php echo $order['credit_amount']; ?></span></td>
            </tr>
            <tr>
                <td>Remaining(Debt) Amount</td>
                <td><span class="popup_final_total"><?php echo $order['debit_amount']; ?></span></td>
            </tr>
        </table>

        <table style="margin-top:30px;" class="table-sm table table-bordered">

            <tr>
                <td>Date</td>
                <td>Type</td>
                <td>Amount</td>
            </tr>
            <?php foreach ($order['order_payment'] as $key => $payment) { ?>
                <tr>
                    <td>{{ date('d-m-Y h:i:s A',strtotime($payment['payment_datetime'])) }}</td>
                    <td><?php if ($payment['payment_type'] == 0) {
                            echo 'Offline';
                        } else {
                            echo 'Online';
                        } ?></td>
                    <td>{{ $payment['amount'] }}</td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<script>
    var order_payment_store = "{{route('order_payment_store')}}";
    $(".save_payment_btn").off("click").on('click', function(e) {
        // $(document).on('click', '.save_payment_btn', function(e) {
        e.preventDefault();
        if ($("#payment_add_form").valid()) {
            $('.save_payment_btn').attr('disabled', true);
            var order_id = $('#order_id').val();
            var payment_type = $('#payment_type').val();
            var amount = $('#amount').val();
            var order_date = $('#order_date').val();
            $.ajax({
                url: order_payment_store,
                type: "POST",
                data: {
                    'payment_type': payment_type,
                    'order_id': order_id,
                    'amount': amount,
                    'order_date': order_date
                },
                success: function(response) {
                    if (response.status == true) {
                        $('.index_modal_content').html('');
                        $('#index_modal').modal('hide');
                        success_noti('Order Payment Received Successfully.');
                        table.draw();
                    } else {
                        $('.index_modal_content').html('');
                        $('#index_modal').modal('hide');
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