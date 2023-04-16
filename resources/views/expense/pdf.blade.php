<!DOCTYPE html>
<html lang="en">

<head>
    <title>ERP-Software</title>
    @include('layouts.common.header_style')
</head>
<style>
    @import url(http://fonts.googleapis.com/css?family=Calibri:400,300,700);

    body {
        background-color: blue;
        font-family: 'Calibri', sans-serif !important;
    }


    .mt-100 {
        margin-top: 50px;
    }

    .mb-100 {
        margin-bottom: 50px;
    }

    .card {
        border-radius: 1px !important;
    }

    .card-header {

        background-color: #fff;
    }

    .card-header:first-child {
        border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
    }

    .btn-sm,
    .btn-group-sm>.btn {
        padding: .25rem .5rem;
        font-size: .765625rem;
        line-height: 1.5;
        border-radius: .2rem;
    }
</style>

<body>
    <div class="container-fluid mt-100 mb-100">
        <div id="ui-view">
            <div>
                <div class="card">
                    <div class="card-header">
                        <h4>Expense Report</h4>
                        <div class="pull-right">
                            <a class="btn btn-sm btn-info" href="#" data-abc="true" onclick="display()"><i class="fa fa-print mr-1"></i>
                                Print</a>
                            {{-- <a class="btn btn-sm btn-info" href="#" data-abc="true"><i
                                    class="fa fa-file-text-o mr-1"></i> Save</a> --}}
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-3">Total Credit:</h6>
                                    Rs <strong>2000</strong>

                            </div>


                            <div class="col-sm-4">
                                <h6 class="mb-3">Total Debit:</h6>
                                    Rs <strong>2000</strong>
                            </div>

                            <div class="col-sm-2">
                                <h6 class="mb-3">Total Debit:</h6>
                                    Rs <strong>2000</strong>
                            </div>
                        </div>

                        <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th>Date</th>
                                        <th class="center">Total Credit</th>
                                        <th class="center">Total Debit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="center">1</td>
                                        <td class="left">Laptops</td>
                                        <td class="left">Macbook Air 8GB RAM, 256GB SSD</td>
                                        <td class="center">5</td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-5 ml-auto">
                                <table class="table table-clear">
                                    <tbody>
                                        <tr>
                                            <td class="left"><strong>Total</strong></td>
                                            <td class="right"><strong>$9000</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    function display() {
        window.print();
         }

</script>
</html>
