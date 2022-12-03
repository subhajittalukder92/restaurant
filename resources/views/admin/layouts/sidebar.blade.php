<div class="col-sm-2 col-xs-6 sidebar pl-0">
    <div class="inner-sidebar mr-3">

        <!--Sidebar Navigation Menu-->
        <div class="sidebar-menu-container">
            <ul class="sidebar-menu mb-4">
            <li class="parent">
                    <a class="{{ Request::is('admin/dashboard*') ? 'active' : '' }}" href="{{route('admin.dashboard.index')}}"><i class="fa fa-dashboard mr-3"></i>
                        <span class="none">Dashboard </span>
                    </a>
                </li>
                <li class="parent">
                    <a class="{{ Request::is('admin/customers*') ? 'active' : '' }}" href="{{route('admin.customers.index')}}"><i class="fa fa-users mr-3"></i>
                        <span class="none">Customers </span>
                    </a>
                </li>
                <li class="parent">
                    <a class="{{ Request::is('admin/menus*') ? 'active' : '' }}" href="{{route('admin.menus.index')}}"><i class="fa fa-cogs mr-3"></i>
                        <span class="none">Menus </span>
                    </a>
                </li>
                <li class="parent">
                    <a class="{{ Request::is('admin/slider*') ? 'active' : '' }}" href="{{route('admin.slider.index')}}"><i class="fa fa-film mr-3"></i>
                        <span class="none">Sliders </span>
                    </a>
                </li>
                <li class="parent">
                    <a class="{{ Request::is('admin/reward*') ? 'active' : '' }}" href="{{route('admin.reward.index')}}"><i class="fa fa-gift mr-3"></i>
                        <span class="none">Rewards </span>
                    </a>
                </li>
                <li class="parent">
                    <a class="{{ Request::is('admin/delivery-boys*') ? 'active' : '' }}" href="{{route('admin.delivery-boys.index')}}"><i class="fa fa-users mr-3"></i>
                        <span class="none">Delivery Boys </span>
                    </a>
                </li>
                <li class="parent">
                    <a class="{{ Request::is('admin/zipcodes*') ? 'active' : '' }}" href="{{route('admin.zipcodes.index')}}"><i class="fa fa-users mr-3"></i>
                        <span class="none">Available Zipcodes </span>
                    </a>
                </li>
                {{-- <li class="parent">
                    <a class="{{ Request::is('admin/menu-category*') ? 'active' : '' }}" href="{{route('admin.menu-category.index')}}"><i class="fa fa-book mr-3"></i>
                        <span class="none">Menu Category </span>
                    </a>
                </li> --}}
                <li class="parent">
                    <a class="{{ Request::is('admin/order*') ? 'active' : '' }}" href="{{route('admin.order.index')}}"><i class="fa fa-gift mr-3"></i>
                        <span class="none">Orders </span> &nbsp;<span class="badge badge-success">{{ \App\Utils\Helper::newOrders() }}</span>
                    </a>
                </li>
                <li class="parent">
                    <a class="{{ Request::is('admin/payment-history*') ? 'active' : '' }}" href="{{route('admin.payment.history')}}"><i class="fa fa-gift mr-3"></i>
                        <span class="none">Payment History</span>
                    </a>
                </li>
                <li class="parent">
                    <a href="{!! url('/admin/logout') !!}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i>
                        <span class="none">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!--Sidebar Naigation Menu-->
        
    </div>
</div>
