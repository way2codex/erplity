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

                                <a href="{{route('create_unit_type')}}"><button class="btn shadow-primary waves-effect waves-light btn-square btn-primary" type="button">
                                        <i class="icon-plus mr-1"></i>Add {{$data['module']}}</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table style="width: 100%;" id="data_table" class="table-sm table-bordered  dataTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Status</th>
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
                            url: "{{ route('delete_unit_type')}}",
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
            ajax: "{{ route('get_unit_type') }}",
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

    });
</script>
@endsection
