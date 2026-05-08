import './bootstrap'; // Import Bootstrap (if needed)
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Initialize Laravel Echo
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY, // Use import.meta.env instead of process.env
    wsHost: window.location.hostname,
    wsPort: 8080,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});

console.log('Laravel Echo initialized:', window.Echo); // Debugging