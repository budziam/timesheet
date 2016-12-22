export default {
    template: require('html!./project-search.html'),

    props: {
        data: Object
    },

    data() {
        return {
            selectNode: {},
            search: '',
            groups: [],
            projects: []
        }
    },

    mounted() {
        this.selectNode = $(this.$refs.groups);

        this.selectNode.select2({
            placeholder: 'Select groups'
        });

        this.refreshProjects();
    },

    methods: {
        getProjectId(project) {
            return 'project-' + project.id;
        },

        getProjectIdHref(project) {
            return '#' + this.getProjectId(project);
        },

        /**
         * Refreshes projects list
         */
        refreshProjects() {
            this.$http.get(this.data.projectsUrl, {
                search: this.search,
                groups: this.groups
            })
                .then(function (response) {
                    this.projects = response.body;
                });
        }
    },

    watch: {
        search() {
            this.refreshProjects();
        }
    }
}