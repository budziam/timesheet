import Laravel from "../../common/laravel";
import WorkLogTime from "../../common/components/work-log-time";

export default {
    template: require('./statistics-project-groups.html'),

    data() {
        return {
            statistics: {
                all: [],
                project_groups: [],
            },
        };
    },

    created() {
        this.fetch();
    },

    methods: {
        fetch() {
            const component = this;

            axios.get(Laravel.url('/dashboard/api/statistics/project-groups'))
                .then(response => component.statistics = response.data)
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
                hour_value: (total === 0 ? 0 : (row.value / total)).toFixed(2)
            };
        }
    },

    computed: {
        all() {
            return this.parseRow(this.statistics.all);
        },
        projectGroups() {
            return this.statistics.project_groups.map(row => this.parseRow(row));
        }
    }
};