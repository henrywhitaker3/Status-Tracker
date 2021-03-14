require('./bootstrap');

import { App, plugin } from '@inertiajs/inertia-vue';
import Vue from 'vue';
import { InertiaProgress } from '@inertiajs/progress';

require('./icons');
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'


Vue.use(plugin);
Vue.use(InertiaProgress);
Vue.component('font-awesome-icon', FontAwesomeIcon)

InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 100,

    // The color of the progress bar.
    color: '#fc0390',

    // Whether to include the default NProgress styles.
    includeCSS: true,

    // Whether the NProgress spinner will be shown.
    showSpinner: false,
});

const el = document.getElementById('app');

new Vue({
    render: h => h(App, {
        props: {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => import(`./Pages/${name}`).then(module => module.default),
        },
    }),
}).$mount(el)
