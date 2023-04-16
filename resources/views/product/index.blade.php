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
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name">Category</label>
                                    <select class="form-control category_id" id="category_id" name="category_id">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4" style="margin-top:2.8%">
                                <button type="submit" class="btn btn-success searchData btn-sm">Apply
                                    </button>
                                <button class="btn btn-danger searchClear btn-sm" data-toggle="collapse" data-target="#filterBody">Cancel</button>
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
                        <h4 class="card-title">{{$data['module']}}</h4>
                        <div class="heading-elements">
                            <div class="btn-group float-md-right">
                                <a href="{{route('create_product')}}"><button class="btn shadow-primary waves-effect waves-light btn-square btn-primary" type="button">
                                        <i class="icon-plus mr-1"></i>Add {{$data['module']}}</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class=" card-dashboard m-1">
                            <div class="table-responsive">
                                <table id="data_table" class="table-bordered dataTable table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Category</th>
                                            <th>Name</th>
                                            <th>Rate</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th style="min-width:120px;">Action</th>
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
{{-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> --}}
<script>
    $(document).ready(function() {
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
                            url: "{{ route('delete_product')}}",
                            type: 'post',
                            data: {
                                "id": id
                            },
                            success: function(response) {
                                window.location.reload();
                            }
                        });
                    }
                });
        });

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
                "url": "{{ route('get_product') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    category_id: function() {
                        return $("#category_id").val()
                    },
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
                {
                    data: 'category.name',
                    name: 'category.name',
                    orderable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'rate',
                    name: 'rate'
                },
                {
                    data: 'current_stock',
                    name: 'current_stock'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });


        $('.searchData').on('click', function(e) {
            e.preventDefault();
            table.draw();
        });

        $('.searchClear').on('click', function(e) {
            e.preventDefault();
            $('body').find('#category_id').val('').trigger('change');
            table.draw();
        });


        $('.category_id').select2({
            placeholder: 'Select Category',
            allowClear: true,
            ajax: {
                url: "{{ route('get_ajax_category') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

    });
</script>
@endsection
