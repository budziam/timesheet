require('../bootstrap');
require('bootstrap-sidebar/dist/js/sidebar');
require('bootstrap-notify');

import ProjectIndex from './components/project-index';
import ProjectCreateEdit from './components/project-createedit';
import WorkLogIndex from './components/work-log-index';

window.vueApp = new Vue({
    el: '#app',

    components: {
        ProjectIndex,
        ProjectCreateEdit,
        WorkLogIndex
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
