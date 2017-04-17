require('../bootstrap');
require('bootstrap-sidebar/dist/js/sidebar');
require('bootstrap-notify');

import ProjectIndex from './components/project-index';
import ProjectCreateedit from './components/project-createedit';
import UserIndex from './components/user-index';
import UserCreateedit from './components/user-createedit';
import WorkLogIndex from './components/work-log-index';
import WorkLogCreateedit from './components/work-log-createedit';

window.vueApp = new Vue({
    el: '#app',

    components: {
        ProjectIndex,
        ProjectCreateedit,
        UserIndex,
        UserCreateedit,
        WorkLogIndex,
        WorkLogCreateedit
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
