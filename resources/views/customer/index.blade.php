@extends('layouts.app')
@section('title')
{{$data['title']}}
@endsection
@section('custom_style')

@endsection
@section('main')

<div class="content-body">
    <section id="configuration">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$data['module']}}</h4>
                        <div class="heading-elements">
                            <div class="btn-group float-md-right">
                                <a href="{{route('create_'.$data['route'])}}"><button class="btn shadow-primary waves-effect waves-light btn-square btn-primary" type="button">
                                        <i class="icon-plus mr-1"></i>Add {{$data['module']}}</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class=" card-dashboard m-1">
                            <div class="table-responsive">
                                <table style="width: 100%;" id="data_table" class="table-sm table-bordered  dataTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>

                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>City</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Added On</th>
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
<script>
    var table = $('.dataTable').DataTable({
        "scrollX": true,
        'autoWidth': false,
        processing: true,
        serverSide: true,
        ajax: "{{ route('get_customer') }}",
        "order": [
            [0, "asc"]
        ],
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'mobile',
                name: 'mobile'
            },
            {
                data: 'city',
                name: 'city'
            },
            {
                data: 'photo',
                name: 'photo',
                orderable: false,
                searchable: false,
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });
</script>
@include($data['view'].'.script')

@endsection
