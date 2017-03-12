import VDatatable from './datatable';

module.exports = {
    template: require('html!./project-index.html'),

    components: {
        'v-datatable': VDatatable
    },

    props: {
        data: Object
    }
};