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
            projects: [
                {
                    id: 1,
                    name: 'Alfred',
                    groups: [
                        {
                            name: 'Aba'
                        },
                        {
                            name: 'Moja'
                        },
                        {
                            name: 'Min'
                        },
                        {
                            name: 'Staty'
                        },
                    ]
                },
                {
                    id: 2,
                    name: 'Alfred',
                    groups: [
                        {
                            name: 'Aba'
                        },
                        {
                            name: 'Moja'
                        }
                    ]
                },
                {
                    id: 3,
                    name: 'Alfred',
                    groups: [
                        {
                            name: 'Aba'
                        },
                        {
                            name: 'Min'
                        },
                        {
                            name: 'Staty'
                        },
                    ]
                }
            ]
        }
    },

    mounted() {
        this.selectNode = $(this.$refs.groups);

        var options = {
            tags: true
        };

        this.selectNode.select2(options);
    },

    methods: {
        getProjectId(project) {
            return 'project-' + project.id;
        },

        getProjectIdHref(project) {
            return '#' + this.getProjectId(project);
        }
    },

    watch: {
        search(newVal) {
            console.log('Changes: ' + newVal);
        }
    }
}