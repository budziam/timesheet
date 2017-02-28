import debounce from "debounce";

export default {
    template: require('html!./project-search.html'),

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
            return '/work-logs/sync?project_id=' + project.id;
        },

        /**
         * Refreshes projects list
         */
        refreshProjects() {
            axios.get('/api/search/projects/default', {
                params: {
                    search: this.search,
                    groups: this.groups
                }
            })
                .then(function (response) {
                    this.projects = response.body;
                })
                .catch(response => Event.requestError(response));
        }
    },

    watch: {
        search: debounce(function () {
            this.refreshProjects();
        }, 200),

        groups() {
            this.refreshProjects();
        }
    }
}