require('./bootstrap');

import { App, plugin } from '@inertiajs/inertia-vue';
import Vue from 'vue';
import { InertiaProgress } from '@inertiajs/progress';

require('./icons');
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import VTooltip from 'v-tooltip'


Vue.use(plugin);
Vue.use(InertiaProgress);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.use(VTooltip);

Vue.prototype.prettyDiff = function(timestamp, ms = false) {
    if(!ms) {
        var date = new Date(timestamp).getTime();
    }
    var now = new Date().getTime();

    return window.prettyMilliseconds(
        (now - date),
        {
            secondsDecimalDigits: 0
        }
    );
};

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
