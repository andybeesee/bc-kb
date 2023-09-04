import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { vOnClickOutside } from '@vueuse/components'
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
import AppLayout from './AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Datetime from "./directives/Datetime.js";
import datetime from "./directives/Datetime.js";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        const page = await resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue'));
        page.default.layout = page.layout || AppLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .directive('click-outside', vOnClickOutside)
            .component('Link', Link);

        app.config.globalProperties.$filters = {
            datetime: datetime,
        };

        return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
