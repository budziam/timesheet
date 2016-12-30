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