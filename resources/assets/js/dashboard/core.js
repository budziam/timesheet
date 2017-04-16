require('../bootstrap');
require('bootstrap-sidebar/dist/js/sidebar');
require('bootstrap-notify');

import ProjectIndex from './components/project-index';
import ProjectCreateEdit from './components/project-createedit';

window.vueApp = new Vue({
    el: '#app',

    components: {
        ProjectIndex,
        ProjectCreateEdit
    },

    created() {
        Event.$on('notify', (type, message, params) => {
            $.notify({
                message: this.$trans(message, params)
            }, {
                type: type
            });
        });
    },
});
