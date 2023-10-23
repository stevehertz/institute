<div class="wrap-header-mobile">
    <!-- Logo moblie -->
    <div class="logo-mobile">
        <a href="{{ url('/') }}"><img src="{{ asset('storage/logo/logo.png') }}" alt="IMG-LOGO"></a>
    </div>

    <!-- Icon header -->
    <div class="wrap-icon-header flex-w flex-r-m m-r-15">

        {{-- <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
            <i class="zmdi zmdi-search"></i>
        </div> --}}

        <a href="{{ route('cart.index') }}" class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
            @if (auth()->check() && Cart::session(auth()->user()->id)->getTotalQuantity() != 0) data-notify="{{ Cart::session(auth()->user()->id)->getTotalQuantity() }}"
        @else
        data-notify="0" @endif>
            <i class="zmdi zmdi-shopping-cart"></i>
        </a>

        {{-- <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
            data-notify="0">
            <i class="zmdi zmdi-favorite-outline"></i>
        </a> --}}
    </div>

    <!-- Button show menu -->
    <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
        <span class="hamburger-box">
            <span class="hamburger-inner"></span>
        </span>
    </div>
</div>
