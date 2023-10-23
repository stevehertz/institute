<ul class="topbar-mobile">
    <li>
        <div class="left-top-bar">
            Welcome to CCIB Institute
        </div>
    </li>

    <li>
        <div class="right-top-bar flex-w h-full">

            @guest
                <a href="javascript:void(0)" class="flex-c-m trans-04 p-lr-25" id="openLoginModal" data-target="#myModal">
                    @lang('navs.general.login')
                </a>
            @else
                @if ($logged_in_user->hasRole('student'))
                    <a href="{{ route('admin.dashboard') }}" class="flex-c-m trans-04 p-lr-25" target="_blank">
                        @lang('navs.frontend.dashboard')
                    </a>
                @else
                    @can('view backend')
                        <a href="{{ route('admin.dashboard') }}" class="flex-c-m trans-04 p-lr-25" target="_blank">
                            @lang('navs.frontend.dashboard')
                        </a>
                    @endcan
                @endif

            @endguest

            {{-- <a href="#" class="flex-c-m p-lr-10 trans-04">
                Help & FAQs
            </a> --}}

            <a href="#" class="flex-c-m p-lr-10 trans-04">
                @lang('menus.language-picker.language')({{ strtoupper(app()->getLocale()) }})
            </a>

            <a href="#" class="flex-c-m p-lr-10 trans-04">
                USD
            </a>
        </div>
    </li>
</ul>
