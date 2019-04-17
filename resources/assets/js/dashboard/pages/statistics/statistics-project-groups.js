import Laravel from '../../../common/laravel';
import WorkLogTime from '../../../common/components/work-log-time';

export default {
    template: require('./statistics-project-groups.html'),

    data() {
        return {
            startYears: [],
            endYears: [],
            onlyCompleted: false,
            statistics: {
                all: [],
                project_groups: [],
            },
            years: yearsRange(),
        };
    },

    created() {
        this.fetch();
    },

    methods: {
        fetch() {
            const params = this.filters;

            axios.get(Laravel.url('/dashboard/api/statistics/project-groups'), {params})
                .then(response => this.statistics = response.data)
                .catch(error => Event.requestError(error));
        },

        parseRow(row) {
            const total = row.office + row.fieldwork;

            return {
                project_group: row.project_group,
                office: WorkLogTime.timePretty(row.office),
                fieldwork: WorkLogTime.timePretty(row.fieldwork),
                total: WorkLogTime.timePretty(total),
                value: (row.value / 100).toFixed(2),
                hour_value: WorkLogTime.getHourValue(row.value / 100, total).toFixed(2),
            };
        },

        toggleOnlyCompleted() {
            this.onlyCompleted = !this.onlyCompleted;
        }
    },

    computed: {
        all() {
            return this.parseRow(this.statistics.all);
        },
        projectGroups() {
            return this.statistics.project_groups.map(row => this.parseRow(row));
        },
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
