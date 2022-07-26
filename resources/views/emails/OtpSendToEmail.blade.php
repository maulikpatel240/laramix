@component('mail::message')
# Use of otp in your Business.

Please use the verification code below on Beauty website.

@component('mail::panel')
Otp:@php echo $request['otp'] @endphp 
@endcomponent
If you did not request this, you can ignore this email or let us know.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
  