/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;
window.Echo = Echo;
/*
window.getEcho = function () {
    return {
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
        wsHost: window.location.hostname,
        wsPort: null,
        wssPort: null,
        forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
        enabledTransports: ['ws', 'wss'],
    };
}
*/

window.Echo = new Echo({
     broadcaster: 'pusher',
     key: import.meta.env.VITE_PUSHER_APP_KEY,
     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
     wsHost: window.location.hostname,
     wsPort: null,
     wssPort: null,
     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
     enabledTransports: ['ws', 'wss'],
});