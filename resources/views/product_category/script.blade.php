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
                            url: "{{ route('delete_product_category')}}",
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
            ajax: "{{ route('get_product_category') }}",
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
                    data: 'image',
                    name: 'image',
                    orderable:false,
                    searchable:false,
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
