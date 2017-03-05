require('../bootstrap');
require('bootstrap-notify');

import Loader from './components/loader';
import ProjectSearch from './components/project-search';
import WorkLogSync from './components/work-log-sync';
import WorkLogIndex from './components/work-log-index';

window.vueApp = new Vue({
    el: '#app',

    components: {
        Loader,
        Notification,
        ProjectSearch,
        WorkLogSync,
        WorkLogIndex
    },

    beforeMount() {
        $.fn.select2.defaults.set("theme", "bootstrap");
        $.fn.select2.defaults.set("containerCssClass", ":all:");
        $.fn.select2.defaults.set("width", null);
        $.fn.select2.defaults.set('debug', true);
        $.fn.select2.defaults.set("language", Laravel.lang);
    },

    created() {
        Event.$on('notify', (type, message, params) => {
            $.notify({
                message: this.$trans(message, params)
            }, {
                type: type
            });
        });
    }
});
