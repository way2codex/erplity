<!-- Bootstrap core JavaScript-->
<script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>

<!-- simplebar js -->
<script src="{{ asset('public/assets/plugins/simplebar/js/simplebar.js') }}"></script>
<!-- waves effect js -->
<script src="{{ asset('public/assets/js/waves.js') }}"></script>
<!-- sidebar-menu js -->
<script src="{{ asset('public/assets/js/sidebar-menu.js') }}"></script>
<!-- Custom scripts -->
<script src="{{ asset('public/assets/js/app-script.js') }}"></script>

<!--notification js -->
<script src="{{ asset('public/assets/plugins/notifications/js/lobibox.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/notifications/js/notifications.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/bootstrap-datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/alerts-boxes/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/select2/js/select2.min.js') }}"></script>

<script src="{{ asset('public/assets/plugins/jquery.repeater.js') }}"></script>
<script src="{{ asset('public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('public/assets/plugins/Chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/Chart.js/chartjs-script.js') }}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // CKEDITOR.replace('description');
</script>
<script>
    $('body').on('click', '#logout', function(e) {
        $('#logoutForm').trigger('submit');
    });
    $('.language').hover(function() {
        $('.dropdown-toggle', this).trigger('click');
    });


    function warning_noti(message) {
        Lobibox.notify('warning', {
            pauseDelayOnHover: false,
            continueDelayOnInactiveTab: false,
            size: 'mini',
            position: 'top right',
            icon: 'fa fa-info-circle',
            msg: message
        });
    }

    function success_noti(message) {
        Lobibox.notify('info', {
            pauseDelayOnHover: false,
            continueDelayOnInactiveTab: false,
            size: 'mini',
            position: 'top right',
            icon: 'fa fa-info-circle',
            msg: message
        });
    }

    function error_noti(message) {
        Lobibox.notify('error', {
            pauseDelayOnHover: false,
            continueDelayOnInactiveTab: false,
            size: 'mini',
            position: 'top right',
            icon: 'fa fa-close',
            msg: message
        });
    }

    $.validator.addMethod("multiple_row_required_validation_rule", function(value, element) {
        var flag = true;
        if ($(element).val().trim() == '') {
            flag = false;
            var error_msg = $(element).attr('validation-error') ? $(element).attr('validation-error') : $(element).attr('placeholder');
            $(element).closest("div").find(".validation_error").remove();
            $(element).closest("div").append('<label class="validation_error error">' + error_msg + '</label>');
        } else {
            $(element).closest("div").find(".validation_error").remove();
        }
        return flag;
    }, "");
</script>

<script>
    $('.datepicker').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true
    });
</script>

<script>
    <?php if (\Session::get('type') == "success") { ?>
        success_noti("{{ Session::get('message') }}")
    <?php } ?>
    <?php if (\Session::get('type') == "error") { ?>
        error_noti("{{ Session::get('message') }}")
    <?php } ?>
</script>

<script>
    function ajax_select2_customer() {
        $('.customer_id').select2({
            placeholder: 'Select Customer',
            allowClear: true,
            ajax: {
                url: "{{ route('get_ajax_customer') }}",
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
    }

    function ajax_select2_supplier() {
        $('.supplier_id').select2({
            placeholder: 'Select Supplier',
            allowClear: true,
            ajax: {
                url: "{{ route('get_ajax_supplier') }}",
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
    }
</script>
