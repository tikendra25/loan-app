@component('mail::message')

Hi {{$user->name}},

You are registered successfully.

<!--@component('mail::button', ['url' => ''])
Button Text
@endcomponent-->

Thanks,<br>
{{ config('app.name') }}
@endcomponent
