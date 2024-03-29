<header>
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        @include('frontend.includes.desktop.top-bar')

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('storage/logo/logo.png') }}" alt="{{ config('app.name') }}">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    @include('frontend.components.main-nav')
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    {{-- <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div> --}}
                    @auth
                        @if ($logged_in_user->hasRole('student'))
                            <a href="{{ route('admin.dashboard') }}"
                                class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                                <i class="zmdi zmdi-account-o"></i>
                            </a>

                            <a href="{{ route('frontend.auth.logout') }}"
                                class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                                <i class="zmdi zmdi-assignment-return"></i>
                            </a>

                            @if (Cart::session(auth()->user()->id)->getTotalQuantity() != 0)
                                <a href="{{ route('cart.index') }}"
                                    class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
                                    data-notify="{{ Cart::session(auth()->user()->id)->getTotalQuantity() }}">
                                    <i class="zmdi zmdi-shopping-cart"></i>
                                </a>
                            @else
                                <a href="{{ route('cart.index') }}"
                                    class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
                                    data-notify="0">
                                    <i class="zmdi zmdi-shopping-cart"></i>
                                </a>
                            @endif
                        @else
                            @can('view backend')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                                    <i class="zmdi zmdi-account-o"></i>
                                </a>
                            @endcan
                            <a href="{{ route('frontend.auth.logout') }}"
                                class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                                <i class="zmdi zmdi-assignment-return"></i>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('frontend.auth.login') }}"
                            class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                            <i class="zmdi zmdi-account-o"></i>
                        </a>

                        <a href="{{ route('cart.index') }}" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </a>

                    @endauth


                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    @include('frontend.includes.mobile.header')

    <!-- Menu Mobile -->
    @include('frontend.includes.mobile.main-nav')

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="{{ asset('storage/icons/icon-close2.png') }}" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>
