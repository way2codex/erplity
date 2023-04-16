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
                            url: "{{ route('delete_expense') }}",
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
                "url": "{{ route('get_expense') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    from: function() {
                        return $("#from").val();
                    },
                    to: function() {
                        return $("#to").val();
                    },
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'transaction_date',
                    name: 'transaction_date'
                },
                {
                    data: 'transaction_type',
                    name: 'transaction_type'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#from').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                autoclose: true,
            })
            .on('changeDate', function(selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#to').datepicker('setStartDate', minDate);
            });

        $('#to').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                autoclose: true,
            })
            .on('changeDate', function(selected) {
                var maxDate = new Date(selected.date.valueOf());
                $('#from').datepicker('setEndDate', maxDate);
            });

        $('.searchData').on('click', function(e) {
            e.preventDefault();
            table.draw();
        });

        $('.searchClear').on('click', function(e) {
            e.preventDefault();
            $('body').find('#from').val('');
            $('body').find('#to').val('');
            table.draw();
        });

        $('.download_pdf').on('click',function (e) {
            e.preventDefault();
            $('#filterForm').trigger('submit');
         })
    });
</script>
