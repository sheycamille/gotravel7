<x-mail::message>
Hello {{$name}}

Your email verification code:
{{$verification_code}}.


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
