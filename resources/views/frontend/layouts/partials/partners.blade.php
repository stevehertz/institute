<section id="partner" class="partner-section">
    <div class="container">
        <div class="section-title-2 mb65 headline text-left ">
            <h2>{{env('APP_NAME')}} <span>@lang('labels.frontend.layouts.partials.partners')</span></h2>
        </div>
        <div class="partner-item partner-1 text-center">
            @foreach($partners as $partner)
                <div class="partner-pic text-center">
                    <a href="{{ ($partner->link != "") ? $partner->link : '#' }}">
                        <img src={{asset("storage/uploads/".$partner->logo)}} alt="{{$partner->name}}">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
