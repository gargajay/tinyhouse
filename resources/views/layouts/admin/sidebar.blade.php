<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- User menu -->
        <div class="sidebar-section sidebar-user my-1">
            <div class="sidebar-section-body">
                <div class="media">
                    <div class="media-body text-center">
                        <div class="navbar-brand text-center text-lg-left">
                            <a href="{{ route('/') }}" class="d-inline-block">
                                <img src="{{ asset('/images/logo.png') }}" id="round-img" alt="">
                            </a>
                        </div>
                    </div>

                    <div class="ml-3 align-self-center">
                        <button type="button"
                            class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                            <i class="icon-cross2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->
        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <!-- Main -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu"
                        title="Main"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class="icon-pie-chart fa fa-fw"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('seller-user') }}"
                        class="nav-link {{ request()->is('seller-user*') ? 'active' : '' }}">
                        <i class="icon-users fa fa-fw"></i>
                        <span>
                            Seller Users
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('user*') ? 'active' : '' }}">
                        <i class="icon-users fa fa-fw"></i>
                        <span>
                            Buyer Users
                        </span>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('featurelist.index') }}"
                        class="nav-link {{ request()->is('featurelist*') ? 'active' : '' }}">
                        <i class="icon-grid" aria-hidden="true"></i>
                        <span>
                            Vehicle Features
                        </span>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ route('vehicle.index') }}"
                        class="nav-link {{ request()->is('vehicle*') ? 'active' : '' }}">
                        <i class="fa fa-car" aria-hidden="true"></i>
                        <span>
                            Vehicle
                        </span>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('category.index') }}"
                        class="nav-link {{ request()->is('category*') ? 'active' : '' }}">
                        <i class="fa fa-car" aria-hidden="true"></i>
                        <span>
                            Categories
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('subscription.index') }}"
                        class="nav-link {{ request()->is('subscription*') ? 'active' : '' }}">
                        <i class="icon-credit-card2" aria-hidden="true"></i>
                        <span>
                            Subscriptions
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('payments') }}"
                        class="nav-link {{ request()->is('payment*') ? 'active' : '' }}">
                        <i class="icon-credit-card fa fa-fw"></i>
                        <span>
                            Payments
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('settings') }}"
                        class="nav-link {{ request()->is('setting*') ? 'active' : '' }}">
                        <i class="icon-gear fa fa-fw"></i>
                        <span>
                            Settings
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('terms-conditions') }}"
                        class="nav-link {{ request()->is('terms*') ? 'active' : '' }}">
                        <i class="icon-clipboard fa fa-fw"></i>
                        <span>
                            Terms & Conditions
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.logout') }}" class="nav-link">
                        <i class="icon-switch2 fa fa-fw"></i>
                        <span>
                            Logout
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /main navigation -->
    </div>
    <!-- /sidebar content -->
</div>
<style>
</style>
<!-- /main sidebar -->
