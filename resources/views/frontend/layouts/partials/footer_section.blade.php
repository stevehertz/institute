@if(count($section_data['section_content']) > 0)
<div class="footer-menu ml-0 col-md-4">
    <h3 class="widget-title">{{ $section_data['section_title'] }}</h3>
    <ul class="list-inline">
        @foreach($section_data['section_content'] as $item)
            <li><a href="{{$item['link']}}"><i class="fas fa-caret-right"></i>{{$item['label']}}</a></li>
        @endforeach
    </ul>
</div>
@endif