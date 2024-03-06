<div class="top-bar">
    <div class="content-topbar flex-sb-m h-full container">
        <div class="left-top-bar">
            Welcome to {{ config('app.name') }}
        </div>

        <div class="right-top-bar flex-w h-full">

            @guest
                <a href="{{ route('frontend.auth.login') }}" class="flex-c-m trans-04 p-lr-25">
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

            {{-- <a href="#" class="flex-c-m trans-04 p-lr-25">
                Help & FAQs
            </a> --}}

            @if (count($locales) > 1)
                <a href="#" class="flex-c-m trans-04 p-lr-25">
                    @lang('menus.language-picker.language')({{ strtoupper(app()->getLocale()) }})
                </a>
            @endif

            <a href="#" class="flex-c-m trans-04 p-lr-25">
                USD
            </a>
        </div>
    </div>
</div>
