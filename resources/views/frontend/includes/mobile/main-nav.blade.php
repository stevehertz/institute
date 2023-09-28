<div class="menu-mobile">
    @include('frontend.includes.mobile.top-bar')
    <ul class="main-menu-m">
        @if (count($custom_menus) > 0)
            @foreach ($custom_menus as $menu)
                {{-- @if (is_array($menu['id']) && $menu['id'] == $menu['parent']) --}}
                {{-- @if ($menu->subs && count($menu->subs) > 0) --}}
                @if ($menu['id'] == $menu['parent'])
                    @if (count($menu->subs) == 0)
                        <li class="">
                            <a href="{{ asset($menu->link) }}"
                                class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                                id="menu-{{ $menu->id }}">{{ trans('custom-menu.' . $menu_name . '.' . str_slug($menu->label)) }}</a>
                        </li>
                    @else
                        <li class="menu-item-has-children ul-li-block">
                            <a href="#!">{{ trans('custom-menu.' . $menu_name . '.' . str_slug($menu->label)) }}</a>
                            <ul class="sub-menu">
                                @foreach ($menu->subs as $item)
                                    @include('frontend.layouts.partials.dropdown', $item)
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            @endforeach
        @endif
    </ul>
</div>
