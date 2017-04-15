require('../bootstrap');
require('bootstrap-sidebar/dist/js/sidebar');

import ProjectIndex from './components/project-index';
import ProjectEdit from './components/project-edit';

const app = new Vue({
    el: '#app',

    components: {
        ProjectIndex,
        ProjectEdit
    }
});
