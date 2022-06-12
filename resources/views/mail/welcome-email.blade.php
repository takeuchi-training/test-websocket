@component('mail::message')
# Welcome and thanks for joining us!

You have been registed successful.

@component('mail::button', ['url' => 'http://localhost:8000/'])
Visit Us
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
