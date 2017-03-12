require('../bootstrap');
require('bootstrap-sidebar/dist/js/sidebar');

import ProjectIndex from './components/project-index';

const app = new Vue({
    el: '#app',

    components: {
        ProjectIndex
    }
});
