@component('mail::message')
# Welcome

Hi {{ $user->name }}
<br>
Welocome to Bootcamp Laravel, your account has been created successfully, Now you can choose your favorite camp

@component('mail::button', ['url' => route('login')])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
