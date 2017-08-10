@component('mail::message')
# Welcome

The account was created for you on {{ config('app.url') }}

@component('mail::button', ['url' => config('app.url')])
Go to the site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
