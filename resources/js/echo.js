import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'dc7341bc673250f3fc36',
    cluster: 'mt1',
    forceTLS: true,
    encrypted: true, // optional, but safe to include
});
