import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'da524cf29bc1ed97af93',
    cluster: 'ap2',
    forceTLS: true,
    encryption: true,
});