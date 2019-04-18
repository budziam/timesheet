import Laravel from '../../../common/laravel';
import WorkLogTime from '../../../common/components/work-log-time';

export default {
    template: require('./statistics-customers.html'),

    data() {
        return {
            startYears: [],
            endYears: [],
            onlyCompleted: false,
            customers: [],
            loaded: false,
            years: yearsRange(),
        };
    },

    created() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.loaded = false;

            const params = this.filters;
            axios.get(Laravel.url('/dashboard/api/statistics/customers'), {params})
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

        toggleOnlyCompleted() {
            this.onlyCompleted = !this.onlyCompleted;
        },
    },

    computed: {
        filters() {
            return {
                start_years: this.startYears,
                end_years: this.endYears,
                only_completed: this.onlyCompleted ? 1 : 0,
            }
        }
    },

    watch: {
        filters() {
            this.fetch();
        }
    }
};
