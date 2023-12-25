require('../bootstrap');
require('../../vendor/bootstrap-sidebar/js/sidebar');
require('bootstrap-notify');

import CustomerIndex from './pages/customer/customer-index';
import CustomerCreateedit from './pages/customer/customer-createedit';
import ProjectIndex from './pages/project/project-index';
import ProjectCreateedit from './pages/project/project-createedit';
import ProjectGroupIndex from './pages/project-group/project-group-index';
import ProjectGroupCreateedit from './pages/project-group/project-group-createedit';
import StatisticsCustomers from './pages/statistics/statistics-customers';
import StatisticsProjects from './pages/statistics/statistics-projects';
import StatisticsProjectGroups from './pages/statistics/statistics-project-groups';
import UserIndex from './pages/user/user-index';
import UserCreateedit from './pages/user/user-createedit';
import UserChangePassword from './pages/user/user-change-password';
import WorkLogIndex from './pages/work-log/work-log-index';
import WorkLogCreateedit from './pages/work-log/work-log-createedit';

window.vueApp = new Vue({
    el: '#app',

    components: {
        CustomerIndex,
        CustomerCreateedit,
        ProjectIndex,
        ProjectCreateedit,
        ProjectGroupIndex,
        ProjectGroupCreateedit,
        StatisticsCustomers,
        StatisticsProjects,
        StatisticsProjectGroups,
        UserIndex,
        UserCreateedit,
        UserChangePassword,
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

    beforeMount() {
        $.fn.select2.defaults.set("theme", "bootstrap");
        $.fn.select2.defaults.set("containerCssClass", ":all:");
        $.fn.select2.defaults.set("width", null);
        $.fn.select2.defaults.set('debug', true);
        $.fn.select2.defaults.set("language", Laravel.lang);
    }
});
