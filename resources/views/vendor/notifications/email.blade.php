@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# Hallo!
@endif
@endif

{{-- Intro Lines --}}
Je ontvangt deze mail omdat je het wachtwoord herstel formulier hebt ingevuld op karel-chatbot.be. Je kan je wachtwoord herstellen
door op deze knop te klikken!

{{-- Action Button --}}
@component('mail::button', ['url' => $actionUrl, 'color' => "blue"])
Wachtwoord herstellen.
@endcomponent

{{-- Outro Lines --}}
Als je geen wachtwoord herstel hebt aangevraagd kan je deze mail negeren!

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Groetjes,<br>{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
Als je problemen hebt met klikken op de "Wachtwoord herstellen" knop, kan je deze link in je webbrowser plakken:
[{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset
@endcomponent
