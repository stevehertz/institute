<div class="top-bar">
    <div class="content-topbar flex-sb-m h-full container">
        <div class="left-top-bar">
            Welcome to {{ config('app.name') }}
        </div>

        <div class="right-top-bar flex-w h-full">

            @guest
                <a href="javascript:void(0)" class="flex-c-m trans-04 p-lr-25"  id="openLoginModal" data-target="#myModal">
                    @lang('navs.general.login')
                </a>

                <a href="#" class="flex-c-m trans-04 p-lr-25">
                    Register
                </a>
            @else
                <a href="#" class="flex-c-m trans-04 p-lr-25">
                    My Account
                </a>
            @endguest

            <a href="#" class="flex-c-m trans-04 p-lr-25">
                Help & FAQs
            </a>

            <a href="#" class="flex-c-m trans-04 p-lr-25">
                EN
            </a>

            <a href="#" class="flex-c-m trans-04 p-lr-25">
                USD
            </a>
        </div>
    </div>
</div>