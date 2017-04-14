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
                processing: true,
                serverSide: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.13/i18n/Polish.json"
                }
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