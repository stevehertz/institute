<section id="client" class="client-section">
    <div class="container">
        <div class="section-title-2 mb65 headline text-left ">
            <h2>{{env('APP_NAME')}} <span>@lang('labels.frontend.layouts.partials.clients')</span></h2>
        </div>
        <div class="client-item client-1 text-center">
            @foreach($clients as $client)
                <div class="client-pic text-center">
                    <a href="{{ ($client->link != "") ? $client->link : '#' }}">
                        <img src={{asset("storage/uploads/".$client->logo)}} alt="{{$client->name}}">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
