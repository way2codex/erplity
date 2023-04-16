<div class="card">
    <div class="card-header border-0">
        Today's Due Payment | Date: {{ date('d-M-Y') }}
    </div>
    <div class="table-responsive">
        <table class="table table-bordered w-100" id="due_datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order No</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Order Date</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
