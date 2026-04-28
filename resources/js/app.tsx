import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import { configureEcho } from '@laravel/echo-react';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: document.querySelector('meta[name="reverb-host"]')?.getAttribute('content') || import.meta.env.VITE_REVERB_HOST || window.location.hostname,
    wsPort: (document.querySelector('meta[name="reverb-port"]')?.getAttribute('content') || import.meta.env.VITE_REVERB_PORT) ?? 8080,
    wssPort: (document.querySelector('meta[name="reverb-port"]')?.getAttribute('content') || import.meta.env.VITE_REVERB_PORT) ?? 8080,
    forceTLS: (document.querySelector('meta[name="reverb-scheme"]')?.getAttribute('content') || import.meta.env.VITE_REVERB_SCHEME || 'http') === 'https',
    enabledTransports: ['ws', 'wss'],
    authEndpoint: '/broadcasting/auth',
});

configureEcho({
    broadcaster: 'reverb',
});

configureEcho({
    broadcaster: 'reverb',
});

configureEcho({
    broadcaster: 'reverb',
});


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.tsx`,
            import.meta.glob('./pages/**/*.tsx'),
        ),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});


