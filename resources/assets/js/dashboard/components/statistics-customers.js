import Laravel from "../../common/laravel";
import WorkLogTime from "../../common/components/work-log-time";

export default {
    template: require('./statistics-customers.html'),

    data() {
        return {
            customers: [],
            loaded: false,
        };
    },

    created() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.loaded = false;
            axios.get(Laravel.url('/dashboard/api/statistics/customers'))
                .then(response => {
                    this.customers = response.data.map(row => this.parseRow(row));
                    this.loaded = true;
                })
                .catch(error => Event.requestError(error));
        },

        parseRow(row) {
            const total = row.office + row.fieldwork;

            return {
                customer: row.customer,
                office: WorkLogTime.timePretty(row.office),
                fieldwork: WorkLogTime.timePretty(row.fieldwork),
                total: WorkLogTime.timePretty(total),
                value: (row.value / 100).toFixed(2),
                hour_value: WorkLogTime.getHourValue(row.value / 100, total).toFixed(2),
            };
        },
    },
};