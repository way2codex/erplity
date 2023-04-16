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
                            url: "{{ route('delete_supplier')}}",
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
            ajax: "{{ route('get_supplier') }}",
            "order": [
                [0, "asc"]
            ],
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
                // {
                //     data: 'gst_no',
                //     name: 'gst_no'
                // },
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
                    orderable:false,
                    searchable:false,
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
    });
</script>
