@component('mail::message')

    # Dear Merchant

I hope you find this email will, We are consumption more than 50% of {{$ingredients}}<br>
Could you please buy more of {{$ingredients}}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
