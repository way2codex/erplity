<script>
    $(document).on('click', '#payment_add_form', function(event) {

        event.preventDefault();
        if ($("#payment_add_form").valid()) {
            $.ajax({
                url: createRoute,
                type: "POST",
                data: $('#payment_add_form').serialize(),
                success: function(response) {
                    if (response.success == true) {
                        toastr.success(response.message, "Success");
                    } else {
                        toastr.error('Something Went Wrong ...', "Error");
                    }
                    $('#add_modal').modal('hide');
                    table.draw();
                }
            });
        }
        return false;
    });
</script>