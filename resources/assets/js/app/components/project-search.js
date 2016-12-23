export default {
    template: require('html!./project-search.html'),

    props: {
        data: Object
    },

    data() {
        return {
            groupsNode: {},

            search: '',
            groups: [],
            projects: []
        }
    },

    mounted() {
        this.initGroups();
        this.refreshProjects();
    },

    methods: {
        initGroups() {
            var options = {
                placeholder: 'Select groups',
                ajax: {
                    url: this.data.projectGroupsUrl,
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * data.per_page) < data.total_count
                            }
                        };
                    }
                }
            };

            var groupsNode = $(this.$refs.groups);
            groupsNode.select2(options);
            this.registerGroupEvents(groupsNode);
        },

        registerGroupEvents(groupNode) {
            var component = this;

            groupNode.on('change', function () {
                var selected = groupNode.find(':selected')
                    .map(function (i, element) {
                        return element.value;
                    })
                    .toArray();

                component.groups = selected;
            });
        },

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