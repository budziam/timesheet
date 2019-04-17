import VDatatable from '../../components/datatable';
import Laravel from '../../../common/laravel';

export default {
    template: require('./project-index.html'),

    components: {
        VDatatable
    },

    data() {
        return {
            startYears: [],
            endYears: [],
            onlyActive: false,
            projectCreateUrl: Laravel.url('/dashboard/projects/create'),
            columns: [
                'ID',
                'L.K.Z',
                'KERG/ID',
                'Name',
                'End date'
            ],
            options: {
                ajax: {
                    url: Laravel.url('/dashboard/api/datatable/projects'),
                    data: (data) => ({
                        ...data,
                        filters: this.filters,
                    }),
                },
                columns: [
                    {
                        name: 'id',
                        data: {
                            _: 'id.display'
                        },
                    },
                    {
                        data: 'lkz',
                    },
                    {
                        data: 'kerg',
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'ends_at'
                    }
                ],
                order: [[0, 'desc']],
                iDisplayLength: 25,
            },
            years: yearsRange(),
        }
    },

    computed: {
        filters() {
            return {
                start_years: this.startYears,
                end_years: this.endYears,
                only_active: this.onlyActive ? 1 : 0,
            }
        },
    },

    watch: {
        filters() {
            this.$refs.datatable.draw();
        }
    }
};
