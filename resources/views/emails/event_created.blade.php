<x-mail::message>
# Hello!

New event Alert! Titled: **{{ $event->title }}**

**Description:** {{ $event->description }}

**Start Time:** {{ $event->start_time }}

**Event Date:** {{$event->event_day}}

<x-mail::button :url="$url">
    View Event!
</x-mail::button>

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
