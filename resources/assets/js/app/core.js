require('../bootstrap');

import Loader from './components/loader';
import ProjectSearch from './components/project-search';
import WorkLogCreate from './components/work-log-create';

window.vueApp = new Vue({
    el: '#app',

    components: {
        Loader,
        ProjectSearch,
        WorkLogCreate
    },

    beforeMount() {
        $.fn.select2.defaults.set("theme", "bootstrap");
        $.fn.select2.defaults.set("containerCssClass", ":all:");
        $.fn.select2.defaults.set("width", null);
        $.fn.select2.defaults.set('debug', true);
        $.fn.select2.defaults.set("language", Laravel.lang);
    }
});
