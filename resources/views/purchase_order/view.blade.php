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
                <h4 class="card-title" id="basic-layout-form">View {{ $data['module'] }}</h4>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <form>
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="name">Customer</label>
                                        <input type="text" class="form-control customer_id select2" value="{{ $order->supplier->name}}" readonly>

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="datepicker"> Order Date</label>
                                        <input type="text" value="<?php echo date('d-m-Y',strtotime($order->order_date)); ?>" name="order_date" class="form-control" placeholder="Order Date" autocomplete="false" readonly />
                                    </div>
                                </div>
                
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="datepicker">Order Number</label>
                                        <input type="text" value="<?php echo $order->order_no ?>" class="form-control" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered w-100">
                                    <tbody>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Product</th>
                                            <th>Rate</th>
                                            <th>Quantity</th>
                                            <th>GST</th>
                                            <th>GST Amount</th>
                                            <th>Total Amount</th>
                                        </tr>

                                        @foreach ($order->purchase_order_product as $key => $p)
                                        <tr>
                                            <th>{{$key+1}}. </th>
                                            <td>{{$p->product->name }} </td>
                                            <td>{{$p->rate }} </td>
                                            <td>{{$p->quantity }} </td>
                                            <td>{{$p->gst_percentage ?? 0 }} </td>
                                            <td>{{number_format($p->gst_amount,2) ?? 0 }} </td>
                                            <td>{{number_format($p->total,2) ?? 0 }} </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th colspan="6">Total</th>
                                            <th>{{ $order->total }}</th>
                                        </tr>

                                        <tr>
                                            <th colspan="6">Discount</th>
                                            <th>{{ $order->discount }}</th>
                                        </tr>

                                        <tr>
                                            <th colspan="6">Final Total</th>
                                            <th>{{ $order->total }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <br>

                        </div>
                        <div class="form-actions">
                            <a href="{{ route($data['route']) }}">
                                <button type="button" class="btn shadow-danger waves-effect waves-light btn-square btn-danger mr-1">
                                    <i class="fa fa-times"></i> Cancel
                                </button>
                            </a>
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
@endsection