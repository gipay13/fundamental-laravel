@component('mail::message')
# Register Camp: {{ $checkout->camp->bootcamp_name }}

Hi {{ $checkout->user->name }}
<br>
Thank your for register on <b>{{ $checkout->camp->bootcamp_name }}</b>, please see payment instruction by clicking the button bellow

@component('mail::button', ['url' => route('checkout.invoice', $checkout->id)])
Get Invoice
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
