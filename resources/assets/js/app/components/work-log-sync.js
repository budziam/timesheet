export default {
    template: require('html!./work-log-sync.html'),

    props: {
        data: Object
    },

    data() {
        return {
            project: this.data.projectSelected,
        }
    },

    methods: {
        onDayRender(date, cell) {
            let title = this.$trans('Dodaj godziny');

            console.log(cell);

            cell.append(`
                <button class="btn btn-default fc-log-time">${title}</button>
            `);
        },
    },

    computed: {
        workLogsUrl() {
            return {
                url: this.data.workLogsSearchUrl,
                data: {
                    project_id: this.project
                }
            };
        }
    }
}