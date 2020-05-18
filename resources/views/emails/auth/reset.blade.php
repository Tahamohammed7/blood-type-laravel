@component('mail::message')
# Introduction

Blood Bank Reset Password.

<p>Hello {{$client->name}}</p>

<p>Your reset code is : {{$client->pin_code}}</p>

<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->


Thanks,<br>
{{ config('app.name') }}
@endcomponent
