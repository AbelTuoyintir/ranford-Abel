import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});
// window.Echo.channel('voting')
//     .listen('.vote.cast', (data) => {
//         console.log('Vote cast:', data);
//         // Update the UI with the new vote statistics
//         updateVoteStats(data.poll_stats);
//     });

// function updateVoteStats(stats) {
//     stats.forEach(stat => {
//         const candidateElement = document.querySelector(`#candidate-${stat.id}`);
//         if (candidateElement) {
//             const voteCountElement = candidateElement.querySelector('.vote-count');
//             if (voteCountElement) {
//                 voteCountElement.textContent = stat.total_votes;
//             }
//         }
//     });
// }