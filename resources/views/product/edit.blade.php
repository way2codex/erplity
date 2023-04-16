@extends('layouts.app')
@section('title')
    {{ $data['title'] }}
@endsection
@section('custom_style')
    <style>
        .has-error .select2-selection {
            border: 1px solid #a94442;
            border-radius: 4px;
        }

        body {
            overflow-x: hidden;
        }
    </style>
@endsection
@section('main')
    <div class="content-body">
        <section id="basic-form-layouts">
            <div class="row match-height">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-form">Edit {{ $data['module'] }}</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <form action="{{ route('update_product') }}" id='add_form' name="add_form" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id" name="id" value="{{ $product['id'] }}">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input value="{{ $product['name'] }}" type="text"
                                                        class="form-control" placeholder="Name" id='name'
                                                        name="name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">HSN Code</label>
                                                    <input value="{{ $product['hsn_code'] }}" type="text"
                                                        class="form-control" placeholder="HSN Code" id='hsn_code'
                                                        name="hsn_code">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Category</label>
                                                    <select class="form-control select2" id="category_id"
                                                        name="category_id">
                                                        <option value="">Select Option</option>
                                                        <?php foreach ($category as $key => $val) { ?>
                                                        <option <?php
                                                        if ($val['id'] == $product['category_id']) {
                                                            echo 'selected';
                                                        }
                                                        ?> value="{{ $val['id'] }}">
                                                            {{ $val['name'] }}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Unit Type</label>
                                                    <select class="form-control select2" id="unit_type_id"
                                                        name="unit_type_id">
                                                        <option value="">Select Option</option>
                                                        <?php foreach ($unit_type as $key => $val) { ?>
                                                        <option <?php
                                                        if ($val['id'] == $product['unit_type_id']) {
                                                            echo 'selected';
                                                        }
                                                        ?> value="{{ $val['id'] }}">
                                                            {{ $val['name'] }}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Status</label>
                                                    <select id="status" name="status" class="select2 form-control">
                                                        <option <?php
                                                        if ($product['status'] == 1) {
                                                            echo 'selected';
                                                        }
                                                        ?> value="1">Active</option>
                                                        <option <?php
                                                        if ($product['status'] == 0) {
                                                            echo 'selected';
                                                        }
                                                        ?> value="0">InActive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Rate</label>
                                                    <input value="{{ $product['rate'] }}" type="number"
                                                        class="form-control" placeholder="Rate" id='rate'
                                                        name="rate">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Minimumn Order Quantity</label>
                                                    <input type="text" value="{{ $product['minimumn_order_quantity'] }}"
                                                        class="form-control" placeholder="Minimumn Order Quantity"
                                                        id='minimumn_order_quantity' name="minimumn_order_quantity">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Stock Alert Quantity</label>
                                                    <input value="{{ $product['stock_alert_quantity'] }}" type="number"
                                                        value="0" class="form-control"
                                                        placeholder="Minimumn Stock Alert Quantity"
                                                        id='stock_alert_quantity' name="stock_alert_quantity">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Main Image</label>
                                                    <input type="hidden" value="{{ $product['main_image'] }}"
                                                        id="old_main_image" name="old_main_image" />
                                                    <input type="file" class="form-control main_image" id="main_image"
                                                        name="main_image" />
                                                    <br><br>
                                                    <img style="width: 150px; height: 150px;" src="<?php echo url('storage/app/product/' . $product['main_image']); ?>" />

                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Product Description</label>
                                                    <textarea class="form-control description" id="description" name="description"> {{ $product['description'] }} </textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="product_images_repeater col-md-12">
                                                <label for="name">ADD MORE IMAGES</label>
                                                <div style="margin-bottom: 10px;" class="row">
                                                    <?php foreach ($product['product_images'] as $key_image => $item_image) { ?>
                                                    <div style="text-align: center;" class="col-md-3 image_div">
                                                        <img style="width: 150px; height: 150px;"
                                                            src="<?php echo url('storage/app/product/' . $item_image['image']); ?>" />
                                                        <br>
                                                        <button type="button" data-id="{{ $item_image['id'] }}"
                                                            style="margin-top: 2px;"
                                                            class="btn shadow-danger btn-danger btn-square btn-sm delete_product_image">Delete</button>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-md-8" data-repeater-list="product_images">
                                                    <div style="display: none;" class="row" data-repeater-item>
                                                        <div class="col-md-6">
                                                            <input type="file" class="form-control product_image "
                                                                name="product_image" />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input data-repeater-delete
                                                                class="btn shadow-danger btn-danger btn-square btn-sm"
                                                                type="button" value="Delete" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <input style="margin:10px;"
                                                    class="btn shadow-primary btn-primary btn-square btn-sm"
                                                    data-repeater-create type="button" value="Add Image" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-actions">
                                        <button type="submit"
                                            class="btn shadow-primary waves-effect waves-light btn-square btn-primary">
                                            <i class="fa fa-check-square-o"></i> Save
                                        </button>
                                        <a href="{{ route('product') }}">
                                            <button type="button"
                                                class="btn shadow-danger waves-effect waves-light btn-square btn-danger mr-1">
                                                <i class="fa fa-times"></i> Cancel
                                            </button>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
<script src="{{ asset('public/assets/plugins/ckeditor/ckeditor.js') }}"></script>
@section('custom_script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            CKEDITOR.replace('description');
            $('.product_images_repeater').repeater({
                defaultValues: {},
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },
                ready: function(setIndexes) {},
                isFirstItemUndeletable: false
            });


            $("#add_form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    category_id: {
                        required: true
                    },
                    unit_type_id: {
                        required: true
                    },
                    rate: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "Please enter a name",
                    },
                    category_id: {
                        required: "Please enter a category id",
                    },
                    unit_type_id: {
                        required: "Please enter a unit type id",
                    },
                    rate: {
                        required: "Please enter a rate",
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
            $(document).on('click', '.delete_product_image', function(e) {
                var self_element = $(this);
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
                                url: "{{ route('delete_product_image') }}",
                                type: 'post',
                                data: {
                                    "id": id
                                },
                                success: function(response) {
                                    $(self_element).parents('.image_div').hide();
                                    success_noti('Deleted Successfully');
                                }
                            });
                        }
                    });
            });
        });
    </script>
@endsection
