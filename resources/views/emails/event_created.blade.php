<x-mail::message>
# {{ $event->title }}

{{ $event->description }}

**Start Time:** {{ $event->start_time }}

Thank you for your interest in our event!

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
