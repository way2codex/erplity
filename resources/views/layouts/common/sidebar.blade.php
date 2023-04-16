<!--Start sidebar-wrapper-->
<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
        <a href="{{ route('home') }}">
            <img src="{{ Helper::setting()->logo }}" class="logo-icon" alt="logo icon" style="height:30px;width:30px;border-radius:100%;margin-top:6px;">
            @if(strlen(Helper::setting()->company_name) <= 14) @php $style='' ; @endphp @else @php $style='font-size:10px' ; @endphp @endif <h6 class="logo-text" style="{{$style}}"> {{ substr(Helper::setting()->company_name,0,23) }}</h6>
        </a>
    </div>
    <div class="user-details">
        <div class="media align-items-center user-pointer collapsed" data-toggle="collapse" data-target="#user-dropdown">
            <div class="avatar"><img class="mr-3 side-user-img" src="{{ asset('public/assets/images/common.png') }}" alt="user avatar"></div>
            <div class="media-body">
                <h6 class="side-user-name">{{ auth()->user()->name }}</h6>
            </div>
        </div>
        <div id="user-dropdown" class="collapse">
            <ul class="user-setting-menu">
                <li><a href="{{ route('setting') }}"><i class="icon-settings"></i> Setting</a></li>
                <li><a href="#" id="logout"><i class="icon-power"></i> Logout</a></li>
                <form id="logoutForm" method="POST" action="{{ route('logout') }}">@csrf()</form>
            </ul>
        </div>
    </div>
    <ul class="sidebar-menu do-nicescrol">
        <!-- <li class="sidebar-header">MAIN NAVIGATION</li> -->
        <li>
            <a href="{{ route('home') }}" class="waves-effect active"><i class="icon-home"></i><span>Dashboard</span></a>
        </li>
        <li class="{{ Request::is('unit_type/*') || Request::is('product_category/*') ? 'active' : ''}}">
            <a href="#" class="waves-effect">
                <i class="icon-diamond"></i><span>General Masters</span><i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="sidebar-submenu {{ Request::is('unit_type/*') || Request::is('product_category/*') ? 'active' : ''}}">
                <li class="{{ Request::is('unit_type/*') ? 'active' : ''}}"><a href="{{ route('unit_type') }}"><i class="fa fa-long-arrow-right"></i> Unit Type</a></li>
                <li class="{{ Request::is('product_category/*') ? 'active' : ''}}"><a href="{{ route('product_category') }}"><i class="fa fa-long-arrow-right"></i> Product Category</a></li>
            </ul>
        </li>

        <li class="{{ Request::is('supplier/*') || Request::is('customer/*') ? 'active' : ''}}">
            <a href="#" class="waves-effect">
                <i class="fa fa-users"></i><span>User Masters</span><i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="sidebar-submenu {{ Request::is('supplier/*') || Request::is('customer/*')? 'menu-open' : ''}}">
                <li class="{{ Request::is('supplier/*') ? 'active' : '' }}"><a href="{{ route('supplier') }}"><i class="fa fa-long-arrow-right"></i> Suppliers</a></li>
                <li class="{{ Request::is('customer/*') ? 'active' : '' }}"><a href="{{ route('customer') }}"><i class="fa fa-long-arrow-right"></i> Customers</a></li>
            </ul>
        </li>

        <li class="{{ Request::is('product/*') ? 'active' : ''}}">
            <a href="{{ route('product') }}" class="waves-effect {{ Request::is('product/*') ? 'active' : ''}}"><i class="fa fa-product-hunt"></i><span>Products</span></a>
        </li>
        <li class="{{ Request::is('purchase_order/*') ? 'active' : ''}}">
            <a href="{{ route('purchase_order') }}" class="waves-effect {{ Request::is('purchase_order/*') ? 'active' : ''}}"><i class="fa fa-hand-o-down"></i><span>Purchase Order</span></a>
        </li>
        <li class="{{ Request::is('order/*') ? 'active' : ''}}">
            <a href="{{ route('order') }}" class="waves-effect {{ Request::is('order/*') ? 'active' : ''}}"><i class="fa fa-hand-o-up"></i><span>Order</span></a>
        </li>
        <li>
            <a href="{{ route('expense') }}" class="waves-effect "><i class="fa fa-money"></i><span>Expense</span></a>
        </li>

        <li>
            <a href="{{ route('order_payments') }}" class="waves-effect "><i class="fa fa-credit-card"></i><span>Payments</span></a>
        </li>
        <li>
            <a id="logout" href="#" class="waves-effect "><i class='icon-power mr-2'></i><span>Logout</span></a>
        </li>
    </ul>

</div>
<!--End sidebar-wrapper-->