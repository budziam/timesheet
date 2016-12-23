export default {
    template: require('html!./project-search.html'),

    props: {
        data: Object
    },

    data() {
        return {
            search: '',
            groups: [],
            projects: []
        }
    },

    mounted() {
        this.refreshProjects();
    },

    methods: {
        getProjectId(project) {
            return 'project-' + project.id;
        },

        getProjectIdHref(project) {
            return '#' + this.getProjectId(project);
        },

        getWorkLogUrl(project) {
            return this.data.workLogUrl + '?project_id=' + project.id;
        },

        /**
         * Refreshes projects list
         */
        refreshProjects() {
            this.$http.get(this.data.projectsUrl, {
                params: {
                    search: this.search,
                    groups: this.groups
                }
            })
                .then(function (response) {
                    this.projects = response.body;
                });
        }
    },

    watch: {
        search() {
            this.refreshProjects();
        },

        groups() {
            this.refreshProjects();
        }
    }
}