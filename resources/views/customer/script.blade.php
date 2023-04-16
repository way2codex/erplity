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
                            url: "{{ route('delete_customer')}}",
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

       

       

    });
</script>