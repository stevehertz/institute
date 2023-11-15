<section class="section-slide">
    <div class="wrap-slick1">
        <div class="slick1">
            @foreach ($slides as $slide)
                <div class="item-slick1"
                    style="background-image: url({{ asset('storage/uploads/' . $slide->bg_image) }});">
                    @php $content = json_decode($slide->content) @endphp
                    <div class="container h-full">
                        <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                            <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                                @if ($content->sub_text)
                                    <span class="ltext-101 cl2 respon2">
                                        {{ $content->sub_text }}
                                    </span>
                                @endif
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                                @if ($content->hero_text)
                                    <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
                                        {{ $content->hero_text }}
                                    </h2>
                                @endif
                            </div>
                            @if (isset($content->buttons))
                                <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                                    @foreach ($content->buttons as $button)
                                        <a href="{{ $button->link }}"
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                            {{ $button->label }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
