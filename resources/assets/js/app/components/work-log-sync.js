export default {
    template: require('html!./work-log-sync.html'),

    props: {
        data: Object
    },

    data() {
        return {
            project: this.data.projectSelected,
            workLogs: []
        }
    },

    methods: {
        updateCalendar() {
            var url = this.data.projectsWorkLogsUrl.replace('~project~', this.project);

            this.$http.get(url)
                .then(function (response) {
                    this.workLogs = response.body;
                });
        }
    },

    watch: {
        project() {
            this.updateCalendar();
        }
    }
}