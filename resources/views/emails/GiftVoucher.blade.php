@component('mail::message')
# Hi @php echo $request['recipient_name'] @endphp

You've been sent a @php echo "$".$request['amount'] @endphp gift voucher for @php echo $request['business_name'] @endphp from @php echo $request['sender_name'] @endphp.
<br>
<br>
@php echo $request['message'] @endphp
<br>
<br>
<b>How to use your gift voucher</b>
<br>
<br>
To redeem the gift voucher,print out the attached voucher or use the voucher code: @php echo $request['code'] @endphp
<br>
<br>
<b>How to make an appointment</b>
<br>
<br>
Please call or visit us to arrange an appointment:
<br>
<br>
@php echo $request['business_name'] @endphp<br>
@php echo $request['business_address'] @endphp<br>
@php echo $request['business_phone_number'] @endphp<br>
@php echo $request['business_email'] @endphp<br>
@endcomponent
