<nav id="menu" class="nav-main" role="navigation">
                            
    <ul class="nav nav-main">
        <li class="{{ request()->is('home') ? 'nav-active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-home" aria-hidden="true"></i>
                <span>Dashboard</span>
            </a>                        
        </li>
        {{-- <li class="nav-parent ">
            <a class="nav-link" href="#">
                <i class="fas fa-shopping-basket" aria-hidden="true"></i>
                <span>Orders</span>
            </a>
            <ul class="nav nav-children">
                <li>
                    <a class="nav-link" href="index.html">
                        Submenu 1
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="layouts-default.html">
                        Submenu 2
                    </a>
                </li>
 
            </ul>
        </li> --}}


        <!-- Order route start -->
        @if (auth()->user()->isClient() || auth()->user()->isAdmin() || auth()->user()->can('orders'))
        <li class="{{ request()->is('orders*') ? 'nav-active' : '' }}">
            <a class="nav-link" href="{{ route('order.main') }}">
                <i class="fas fa-shopping-basket" aria-hidden="true"></i>
                <span>Orders</span>
            </a>                        
        </li>
        @endif
        <!-- Order route end -->


        <!-- Invoice route start -->
        @if (auth()->user()->isClient())
            <li class="{{ request()->is('dashboard/invoices*') ? 'nav-active' : '' }}">
                <a class="nav-link" href="{{ route('invoice.client') }}">
                    <i class="fas fa-file-alt"  aria-hidden="true"></i>
                    <span>Invoices</span>
                </a>                        
            </li>
        @endif
        @if (auth()->user()->isAdmin() || auth()->user()->can('invoices'))
            <li class="{{ request()->is('invoices*') ? 'nav-active' : '' }}">
                <a class="nav-link" href="{{ route('invoice.index') }}">
                    <i class="fas fa-file-alt"  aria-hidden="true"></i>
                    <span>Invoices</span>
                </a>                        
            </li>
        @endif
        <!-- Invoice route end -->



        <!-- client route start -->
        @if (auth()->user()->isAdmin() || auth()->user()->can('clients'))
            <li class="{{ request()->is('clients*') ? 'nav-active' : '' }}">
                <a class="nav-link" href="{{ route('client.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Clients</span>
                </a>                        
            </li>
        @endif
        <!-- client route end -->


        <!-- Discounts route start -->
        @if (auth()->user()->isAdmin() || auth()->user()->can('discounts'))
            <li class="{{ request()->is('discount*') ? 'nav-active' : '' }}">
                
                <a class="nav-link" href="{{ route('discount.index') }}">
                    <i class="fas fa-percent"></i>
                    <span>Discounts</span>
                </a>

            </li>
        @endif
        <!-- Discounts route end -->

        <!-- service route start -->
        @if (auth()->user()->isAdmin() || auth()->user()->can('services'))

            <li class="{{ request()->is('services*') ? 'nav-active' : '' }}">
                
                <a class="nav-link" href="{{ route('service.index') }}">
                    <i class="fab fa-searchengin" aria-hidden="true"></i>
                    <span>Services</span>
                </a>

            </li>
        @endif
        <!-- service route start -->

        @if (auth()->user()->isAdmin() || auth()->user()->can('order-form'))
            <li class="{{ request()->is('order-form*') ? 'nav-active' : '' }}">
                
                <a class="nav-link" href="{{ route('order-form.index') }}">
                    <i class="fas fa-list-alt" aria-hidden="true"></i>
                    <span>Order Form</span>
                </a>

            </li>
        @endif

        @if (auth()->user()->isClient())
            <li class="{{ request()->is('dashboard/services') ? 'nav-active' : '' }}">
                
                <a class="nav-link" href="{{ route('services') }}">
                    <i class="fab fa-searchengin" aria-hidden="true"></i>
                    <span>Services</span>
                </a>

            </li>
        @endif

        <li class="{{ request()->is('profile') ? 'nav-active' : '' }}">
            <a class="nav-link" href="{{ route('profile') }}">
                <i class="far fa-user" aria-hidden="true"></i>
                <span>Profile</span>
            </a>                        
        </li>

        @if (auth()->user()->isAdmin())
        <li class="{{ request()->is('settings*') ? 'nav-active' : '' }}">
            <a class="nav-link" href="{{ route('settings') }}">
                <i class="fas fa-cogs" aria-hidden="true"></i>
                <span>Settings</span>
            </a>                        
        </li>
        @endif
        
    </ul>
</nav>