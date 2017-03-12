require('datatables.net');

module.exports = {
    template: require('html!./datatable.html'),

    props: {
        columns: Array,
        options: Object
    },

    data() {
        return {
            dataTable: {},
            defaultOptions: {
                buttons: [],
                processing: true,
                serverSide: true,
            }
        }
    },

    mounted() {
        this.dataTable = $(this.$el).DataTable(this.getOptions());
    },

    methods: {
        /**
         * Returns options for DataTable initialization
         *
         * @returns {Object}
         */
        getOptions() {
            return Object.assign({}, this.defaultOptions, this.options);
        }
    }
};