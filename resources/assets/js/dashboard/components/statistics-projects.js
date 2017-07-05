import Laravel from "../../common/laravel";
import WorkLogTime from "../../common/components/work-log-time";

export default {
    template: require('html!./statistics-projects.html'),

    data() {
        return {
            projectId: null,
            project: null,
            statistics: [],
        }
    },

    methods: {
        fetch() {
            if (!this.projectId) {
                this.project = null;
                this.statistics = [];
                return;
            }

            const component = this;

            Promise.all([
                axios.get(Laravel.url('/dashboard/api/statistics/project-work-logs/' + this.projectId)),
                axios.get(Laravel.url('/dashboard/api/projects/' + this.projectId))
            ])
                .then(([statisticsResponse, projectResponse]) => {
                    component.statistics = statisticsResponse.data;
                    component.project = projectResponse.data;
                })
                .catch(error => Event.requestError(error));
        }
    },

    computed: {
        statisticsFormatted() {
            return this.statistics.map(row => {
                return {
                    employee: row.employee,
                    date: row.date,
                    office: WorkLogTime.timePretty(row.office),
                    fieldwork: WorkLogTime.timePretty(row.fieldwork),
                };
            })
        },

        summary() {
            let office = 0;
            let fieldwork = 0;

            this.statistics.forEach(row => {
                office += row.office;
                fieldwork += row.fieldwork;
            });

            const total = office + fieldwork;

            return {
                office: WorkLogTime.timePretty(office),
                fieldwork: WorkLogTime.timePretty(fieldwork),
                total: WorkLogTime.timePretty(total),
                value: (this.project.value / total * 3600).toFixed(2),
            }
        }
    },

    watch: {
        projectId() {
            this.fetch();
        }
    }
};