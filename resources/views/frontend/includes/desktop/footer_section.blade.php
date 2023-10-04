@if (count($section_data['section_content']) > 0)
    <div class="col-sm-6 col-lg-3 p-b-50">
        <h4 class="stext-301 cl0 p-b-30">
            {{ $section_data['section_title'] }}
        </h4>

        <ul>
            @foreach ($section_data['section_content'] as $item)
                <li class="p-b-10">
                    <a href="{{$item['link']}}" class="stext-107 cl7 hov-cl1 trans-04">
                        {{$item['label']}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
