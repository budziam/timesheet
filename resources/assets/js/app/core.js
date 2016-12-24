require('../bootstrap');

import ProjectSearch from './components/project-search';
import WorkLogCreate from './components/work-log-create';

const app = new Vue({
    el: '#app',

    components: {
        ProjectSearch,
        WorkLogCreate
    },

    beforeMount() {
        $.fn.select2.defaults.set("theme", "bootstrap");
        $.fn.select2.defaults.set("containerCssClass", ":all:");
        $.fn.select2.defaults.set("width", null);
    }
});