import Laravel from '../../../common/laravel';
import WorkLogTime from '../../../common/components/work-log-time';

export default {
    template: require('./statistics-projects.html'),

    props: {
        initialProjectId: [String],
        initialProjectName: [String],
    },

    data() {
        return {
            projectId: null,
            project: null,
            statistics: [],
        }
    },

    created() {
         this.fetch();
    },

    mounted() {
        if (this.initialProjectId) {
            this.$refs.project.select({
                id: this.initialProjectId,
                text: this.initialProjectName,
            });
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

            for (const row of this.statistics) {
                if (row.date) {
                    office += row.office;
                    fieldwork += row.fieldwork;
                }
            }

            const total = office + fieldwork;

            return {
                office: WorkLogTime.timePretty(office),
                fieldwork: WorkLogTime.timePretty(fieldwork),
                total: WorkLogTime.timePretty(total),
                value: WorkLogTime.getHourValue(this.project.value, total).toFixed(2),
            }
        },
    },

    watch: {
        projectId() {
            this.fetch();
        }
    }
};
