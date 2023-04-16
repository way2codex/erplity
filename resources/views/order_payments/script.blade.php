<script>
    $(document).ready(function() {

        ajax_select2_customer();

        $('.payment_type').select2({
            placeholder: "Select Type",
            allowClear: true
        })
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
                "url": "{{ route('get_order_payments') }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    from: function() {
                        return $("#from").val();
                    },
                    to: function() {
                        return $("#to").val();
                    },
                    customer_id: function() {
                        return $("#customer_id").val();
                    },
                    payment_type: function() {
                        return $('#payment_type').val();
                    }

                }
            },
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                var amountTotal = [];
                for (let count = 0; count < data.length; count++) {
                    amountTotal.push(parseInt(data[count].amount));
                }

                const sum = amountTotal.reduce((a, b) => a + b, 0);
                $(api.column(3).footer()).html(
                    `<span class="text-info">Total AMT : ${sum.toFixed(2)}</span>`);
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
                {
                    data: 'order.order_no',
                    name: 'order.order_no',
                    orderable: false
                },
                {
                    data: 'customer_id',
                    name: 'customer_id'
                },
                {
                    data: 'amount',
                    name: 'amount',
                    "render": function(data, type, row, meta) {
                        return data.toFixed(2);
                    },
                },
                {
                    data: 'payment_type',
                    name: 'payment_type',
                },
                {
                    data: 'payment_datetime',
                    name: 'payment_datetime'
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
            $('body').find('#customer_id').val('').trigger('change');
            $('body').find('#payment_type').val('').trigger('change');
            table.draw();
        });
    });
</script>
