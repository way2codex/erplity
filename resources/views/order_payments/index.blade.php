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
                                <input type="text" id="from" name="from" class="form-control" placeholder="Select Start Date" readonly>
                            </div>

                            <div class="col-lg-3">
                                <label for="to">To Date
                                </label>
                                <input type="text" id="to" name="to" class="form-control" placeholder="Enter End Date" readonly>
                            </div>

                            <div class="col-lg-3">
                                    <label for="name">Payment Type</label>
                                    <select class="form-control payment_type" id="payment_type" name="payment_type">
                                        <option value="">Select Type</option>
                                        <option value="0">Offline</option>
                                        <option value="1">Online</option>
                                    </select>
                            </div>

                            <div class="col-lg-4">
                                <button type="submit" class="btn btn-success searchData btn-sm">Apply</button>
                                <button class="btn btn-danger searchClear btn-sm" data-toggle="collapse" data-target="#filterBody">Cancel</button>
                            </div>
                        </div>
                    </div>
              </div>
              <!-- /.card-body -->
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
                                            <th>Order No</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Type</th>
                                            <th>Datetime</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Order No</th>
                                            <th>Customer</th>
                                            <th></th>
                                            <th>Type</th>
                                            <th>Datetime</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@section('custom_script')
@include($data['view'].'.script')
@endsection
