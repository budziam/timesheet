require('../bootstrap');

import ProjectSearch from './components/project-search';

const app = new Vue({
    el: '#app',

    components: {
        ProjectSearch
    },

    beforeMount() {
        $.fn.select2.defaults.set("theme", "bootstrap");
        $.fn.select2.defaults.set("containerCssClass", ":all:");
        $.fn.select2.defaults.set("width", null);
    }
});
