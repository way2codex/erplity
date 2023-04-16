@extends('layouts.app')
@section('title')
    {{ $data['title'] }}
@endsection
@section('custom_style')
@endsection
@section('main')
    <div class="content-body">
        <button type="button" class="btn btn-info filter-btn btn-sm m-2" data-toggle="collapse" data-target="#filterBody"><i
                class="fa fa-filter"></i> Filters</button>
        <section class="content collapse show" id="filterBody">
            <div class="card">
                <div class="card-body">
                    <form id="filterForm" action="{{ route('expense_pdf') }}" method="POST">
                        @csrf()
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="from">From Date <span class="requride_cls">*</span>
                                    </label>
                                    <input type="text" id="from" name="from" class="form-control"
                                        placeholder="Select Start Date" readonly>
                                </div>
                                <div class="col-lg-3">
                                    <label for="to">To Date <span class="requride_cls">*</span>
                                    </label>
                                    <input type="text" id="to" name="to" class="form-control"
                                        placeholder="Enter End Date" readonly>
                                </div>

                                <div class="col-lg-4" style="margin-top:2.8%">
                                    <button type="submit" class="btn btn-success searchData btn-sm">Apply</button>
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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                {{ $data['module'] }}

                                <div class="float-right">
                                    <a href="{{ route('create_expense') }}"><button
                                            class="btn shadow-primary waves-effect waves-light btn-square btn-primary btn-sm"
                                            type="button">
                                            <i class="icon-plus"></i> Add {{ $data['module'] }}</button>
                                    </a>

                                    <a target="_BLANK" href="#"><button
                                            class="btn shadow-warning waves-effect waves-light btn-warning btn-square btn-sm download_pdf"
                                            type="button">
                                            <i class="fa fa-file-pdf-o"></i> Download PDF</button>
                                    </a>
                                </div>

                            </h4>
                            <div class="heading-elements">
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-dashboard m-1">
                                <div class="table-responsive">
                                    <table id="data_table" class="table-bordered dataTable table-sm w-100">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Transaction Date</th>
                                                <th>Type</th>
                                                <th>Action</th>
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
@endsection
@section('custom_script')
    @include($data['view'] . '.script')
@endsection
