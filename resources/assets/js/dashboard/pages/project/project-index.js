import VDatatable from '../../components/datatable';
import Laravel from '../../../common/laravel';

const ONLY_ACTIVE_KEY = "project-only-active";

export default {
    template: require('./project-index.html'),

    components: {
        VDatatable
    },

    data() {
        return {
            startYears: [],
            endYears: [],
            onlyActive: JSON.parse(localStorage.getItem(ONLY_ACTIVE_KEY)) || false,
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

    methods: {
        toggleOnlyActive() {
            this.onlyActive = !this.onlyActive;
            localStorage.setItem(ONLY_ACTIVE_KEY, JSON.stringify(this.onlyActive));
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
