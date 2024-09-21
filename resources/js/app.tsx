import './bootstrap';
import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const pagePath = import.meta.glob('./Pages/**/*.tsx');

createInertiaApp({
  title: (title) => `${title ? `${title} - ` : ' '}${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.tsx`, pagePath),
  setup({ el, App, props }) {
    const root = createRoot(el);
    root.render(<App {...props} />);
  },
  progress: {
    color: '#4B5563',
  },
});
