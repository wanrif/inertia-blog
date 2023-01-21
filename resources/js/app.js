import './bootstrap';
import '../css/app.css';
import 'flowbite';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import CKEditor from '@ckeditor/ckeditor5-vue';
import VueLazyload from 'vue-lazyload';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Wanrif';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({
            render: () => h(App, props)
        })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(CKEditor)
            .use(VueLazyload, {
                preLoad: 1.3,
                error: '/storage/static/error.gif',
                loading: '/storage/static/loading.gif',
                attempt: 1
            })
            .mount(el);
    },
    progress: {
        color: '#6D28D9',
        showSpinner: true,
    },
});
