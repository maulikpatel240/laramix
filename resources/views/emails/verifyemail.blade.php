@component('mail::message')
# Use of staff login credentials in Beauty

Please use the password below to login your email address.

@component('mail::panel')
Email:@php echo $request['email'] @endphp <br>
Password:@php echo $request['password'] @endphp
@endcomponent
If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
