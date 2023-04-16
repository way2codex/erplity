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
    <section id="basic-form-layouts">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="basic-layout-form">Add {{ $data['module'] }}</h4>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <form action="{{ route('store_order') }}" id='add_form' name="add_form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="name">Customer</label>
                                        <select class="form-control customer_id select2" id="customer_id" name="customer_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="datepicker"> Order Date</label>
                                        <input type="text" value="<?php echo date('d-m-Y'); ?>" name="order_date" id="order_date" class="form-control datepicker" placeholder="Select Date" autocomplete="false" readonly />
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="datepicker">Payment Due Date</label>
                                        <input type="text" value="<?php echo date('d-m-Y'); ?>" name="due_date" id="due_date" class="form-control datepicker" placeholder="Select Date" autocomplete="false" readonly />
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="order_product">
                                    <div class="col-md-12" data-repeater-list="order_product">
                                        <div class="row order_product_item" data-repeater-item>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name">Product</label>
                                                    <select validation-error="Please Select Product" class="multiple_row_validation select2 form-control product_id" name="product_id">
                                                        <option value="">Select Product</option>
                                                        <?php foreach ($products as $key => $val) { ?>
                                                            <option value="{{ $val['id'] }}">{{ $val['name'] }}
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <label style="color: green;" class="current_stock_label"></label>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name">Quantity</label>
                                                    <input type="number" validation-error="Please Enter Quantity" class="form-control multiple_row_validation calculate_product_total quantity" placeholder="Quantity" name="quantity">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group rate_class">
                                                    <label for="name">Rate</label>
                                                    <input type="number" validation-error="Please Enter Rate" class="form-control  calculate_product_total rate" placeholder="Rate" name="rate">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name">GST %</label>
                                                    <input type="number" class="form-control calculate_product_total gst_percentage" placeholder="Gst %" name="gst_percentage">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name">GST Amount</label>
                                                    <input type="number" readonly class="form-control calculate_product_total gst_amount" placeholder="Gst Amount" name="gst_amount">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name">Total</label>
                                                    <input type="number" readonly class=" form-control product_total" placeholder="Total" name="total">
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <input data-repeater-delete class="btn shadow-danger btn-danger btn-square btn-sm mt-lg-5" type="button" value="Delete Product" />
                                            </div>
                                            <div class="col-12">
                                                <hr>
                                            </div>
                                        </div>

                                    </div>
                                    <input style="margin:10px;" class="btn shadow-warning btn-warning btn-square" data-repeater-create type="button" value="Add Product" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3">
                                </div>
                                <div class="col-lg-5 text-right">
                                    <div class="form-group">
                                        <label for="name">Total</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Discount</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Final Total</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="number" readonly class="form-control sub_total" placeholder="Sub Total" id='total' name="total">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control calculate_product_total discount" placeholder="Discount" id='discount' name="discount">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" readonly class="form-control final_total" placeholder="Final Total" id='final_total' name="final_total">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <div class="col-md-4">
                                <input class="" type="checkbox" value="1" name="payment_received" id="payment_received" /> Payment Received ?
                                <br> <br>   
                                <select style="display: none;" class="select2 payment_type form-control" id="payment_type" name="payment_type">
                                    <option value="0">Offline</option>
                                    <option value="1">Online</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                            </div>

                            <br>
                            <div class="col-md-4">
                                <button type="submit" class="submit_form_btn btn shadow-primary waves-effect waves-light btn-square btn-primary">
                                    <i class="fa fa-check-square-o"></i> Save
                                </button>
                                <a href="{{ route($data['route']) }}">
                                    <button type="button" class="btn shadow-danger waves-effect waves-light btn-square btn-danger mr-1">
                                        <i class="fa fa-times"></i> Cancel
                                    </button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="{{ asset('public/assets/plugins/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('custom_script')
<script>
    $(document).ready(function() {

        $('#payment_received').change(function() {
            if (this.checked) {
                $('.payment_type').show();
            } else {
                $('.payment_type').hide();
            }
        });


        ajax_select2_customer();

        $('.order_product').repeater({
            defaultValues: {},
            show: function() {
                $(this).slideDown();
                $('.product_id').select2({
                    placeholder: "Select Product"
                });
            },
            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);

                setTimeout(function() {
                    calculate_grand_total();
                }, 1000);

            },
            ready: function(setIndexes) {
                $('.product_id').select2({
                    placeholder: "Select Customer"
                });
            },
            isFirstItemUndeletable: true
        });

        $(document).on('change', '.product_id', function(e) {
            var productElement = $(this);
            var product_id = $(this).val();
            var rate = $(this).parents('.order_product_item').find('.rate');
            var current_stock_label = $(this).parents('.order_product_item').find(
                '.current_stock_label');
            $(current_stock_label).html('');
            $.ajax({
                type: 'POST',
                url: "{{ route('get_product_stock_order') }}",
                data: {
                    product_id: product_id
                },
                success: function(data) {
                    $(current_stock_label).html('Current Stock : <b>' + data.stock +
                        '</b><br>Minimumm Order Quantity: <b>' + data.moq + '</b>');
                    rate.val(data.rate);
                    calculate_product_total(productElement);
                }
            });
        });
        $(document).on('keyup', '.calculate_product_total', function(e) {
            calculate_product_total($(this));
        });

        function calculate_grand_total() {
            var sub_sum = 0;
            $('.product_total').each(function() {
                if (this.value) {
                    sub_sum += parseFloat(this.value);
                }
            });
            $('.sub_total').val(sub_sum);
            if ($('.discount').val()) {
                var discount = parseFloat($('.discount').val());
            } else {
                var discount = 0;
            }

            var grand_total = parseFloat(sub_sum - discount).toFixed(2);
            $('.final_total').val(grand_total);

        }

        function calculate_product_total(self_input) {
            var self_input = $(self_input);

            var parent_div = self_input.parents('.order_product_item');
            var quantity = parent_div.find('.quantity').val();
            var rate = parent_div.find('.rate').val();
            var gst_percentage = parent_div.find('.gst_percentage').val();

            var price_total = quantity * rate;

            var gst_amount = parseFloat((price_total * gst_percentage) / 100);
            parent_div.find('.gst_amount').val(gst_amount.toFixed(2));

            var final_total = parseFloat(price_total + gst_amount).toFixed(2);
            parent_div.find('.product_total').val(final_total);

            calculate_grand_total();
        }
        $(document).on('click', '.submit_form_btn', function(e) {
            e.preventDefault();
            $('.multiple_row_validation').each(function() {
                $(this).rules("add", {
                    multiple_row_required_validation_rule: true,
                });
            });
            if ($("#add_form").valid()) {
                $("#add_form").submit();
            }
        });
        $("#add_form").validate({
            rules: {
                customer_id: {
                    required: true
                },
                final_total: {
                    required: true
                },
            },
            messages: {
                customer_id: {
                    required: "Please enter a Customer",
                },
                final_total: {
                    required: "Add Product/Total",
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
    });
</script>
@endsection