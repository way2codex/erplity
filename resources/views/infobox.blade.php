<div class="row mt-4">
    <div class="col">
        <div class="card gradient-purpink">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left">
                        <h4 class="text-white">{{$dashboard['total_supplier']}}</h4>
                        <span class="text-white">Suppliers</span>
                    </div>
                    <div class="align-self-center"><span id="dash-chart-1"></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card gradient-scooter">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left">
                        <h4 class="text-white">{{ $dashboard['total_customer'] }}</h4>
                        <span class="text-white">Customers</span>
                    </div>
                    <div class="align-self-center"><span id="dash-chart-2"></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card gradient-ibiza">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left">
                        <h4 class="text-white">{{ $dashboard['total_product']}}</h4>
                        <span class="text-white">Products</span>
                    </div>
                    <div class="align-self-center"><span id="dash-chart-3"></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card gradient-ohhappiness">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left">
                        <h4 class="text-white">{{ $dashboard['total_order']}}</h4>
                        <span class="text-white">Orders</span>
                    </div>
                    <div class="align-self-center"><span id="dash-chart-4"></span></div>
                </div>
            </div>
        </div>
    </div>
</div>
