@php
    $footer_data = json_decode(config('footer_data'));
@endphp
<!-- Footer -->

@if ($footer_data != '')
    <footer class="bg3 p-t-75 p-b-32">
        <div class="container">
            <div class="row">
                @if ($footer_data->section1->status == 1)
                    @php
                        $section_data = section_filter($footer_data->section1);
                    @endphp
                    @include('frontend.includes.desktop.footer_section', ['section_data' => $section_data])
                @endif

                @if ($footer_data->section2->status == 1)
                    @php
                        $section_data = section_filter($footer_data->section2);
                    @endphp
                    @include('frontend.includes.desktop.footer_section', ['section_data' => $section_data])
                @endif

                @if ($footer_data->section3->status == 1)
                    @php
                        $section_data = section_filter($footer_data->section3);
                    @endphp

                    @include('frontend.includes.desktop.footer_section', ['section_data' => $section_data])
                @endif

                @if ($footer_data->newsletter_form->status == 1)
                    <div class="col-sm-6 col-lg-3 p-b-50">
                        <h4 class="stext-301 cl0 p-b-30">
                            @lang('labels.frontend.layouts.partials.subscribe_newsletter')
                        </h4>

                        <form action="{{ route('subscribe') }}" method="post">
                            <div class="wrap-input1 w-full p-b-4">
                                <input class="input1 bg-none plh1 stext-107 cl7" type="email" required name="subs_email"
                                    placeholder="@lang('labels.frontend.layouts.partials.email_address').">
                                <div class="focus-input1 trans-04"></div>
                            </div>

                            <div class="p-t-18">
                                <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                    @lang('labels.frontend.layouts.partials.subscribe_now')
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <div class="p-t-40">
                @if ($footer_data->social_links->status == 1 && count($footer_data->social_links->links) > 0)
                    <div class="flex-c-m flex-w p-b-18">
                        @foreach ($footer_data->social_links->links as $item)
                            <a href="{{$item->link}}" class="m-all-1">
                                <i class="{{$item->icon}}"></i>
                            </a>
                        @endforeach
                    </div>
                @endif

                <p class="stext-107 cl6 txt-center">
                    Powered By <a href="#" target="_blank" class="mr-4">{{ config('app.name') }}</a>
                    {!! $footer_data->copyright_text->text !!}
                </p>
            </div>
        </div>
    </footer>
@endif
<!-- Back to top -->
<div class="btn-back-to-top" id="myBtn">
    <span class="symbol-btn-back-to-top">
        <i class="zmdi zmdi-chevron-up"></i>
    </span>
</div>
