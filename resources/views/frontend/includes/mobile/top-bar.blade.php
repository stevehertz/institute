<ul class="topbar-mobile">
    <li>
        <div class="left-top-bar">
            Welcome to CCIB Institute
        </div>
    </li>

    <li>
        <div class="right-top-bar flex-w h-full">

            @guest
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25">
                        Login
                    </a>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="flex-c-m trans-04 p-lr-25">
                        Register
                    </a>
                @endif
            @else
                <a href="#" class="flex-c-m trans-04 p-lr-25">
                    My Account
                </a>
            @endguest

            <a href="#" class="flex-c-m p-lr-10 trans-04">
                Help & FAQs
            </a>

            <a href="#" class="flex-c-m p-lr-10 trans-04">
                EN
            </a>

            <a href="#" class="flex-c-m p-lr-10 trans-04">
                USD
            </a>
        </div>
    </li>
</ul>