<p>@lang('strings.emails.contact.email_body_title')</p>

<p><strong>@lang('validation.attributes.frontend.name'):</strong> {{ $request->first_name }} {{ $request->last_name }}</p>
<p><strong>@lang('validation.attributes.frontend.email'):</strong> {{ $request->email }}</p>
<p><strong>@lang('validation.attributes.frontend.phone'):</strong>  {{ ($request->phone == "") ? "N/A" : $request->phone }}</p>
<p><strong>@lang('validation.attributes.frontend.organization'):</strong>  {{ $request->organization }}</p>
<p><strong>@lang('validation.attributes.frontend.country'):</strong>  {{ $request->country }}</p>
<p><strong>@lang('validation.attributes.frontend.title'):</strong>  {{ $request->title }}</p>
<p><strong>@lang('validation.attributes.frontend.topic'):</strong>  {{ $request->topic }}</p>
<p><strong>@lang('validation.attributes.frontend.message'):</strong> {{ $request->message }}</p>